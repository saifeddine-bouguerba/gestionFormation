<?php
// test/automated_flow_test.php
// Usage: php automated_flow_test.php [base_url]
// Example: php automated_flow_test.php http://localhost:8000

$base = $argv[1] ?? 'http://localhost:8000';
if (substr($base, -1) === '/') $base = rtrim($base, '/');

function http_get($url, $cookieJar=null, $follow=true) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $follow);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieJar ?: sys_get_temp_dir() . '/cf_test_cookies.txt');
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieJar ?: sys_get_temp_dir() . '/cf_test_cookies.txt');
    $resp = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);
    return [$info, $resp];
}

function http_post($url, $data, $cookieJar=null, $follow=true) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $follow);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieJar ?: sys_get_temp_dir() . '/cf_test_cookies.txt');
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieJar ?: sys_get_temp_dir() . '/cf_test_cookies.txt');
    $resp = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);
    return [$info, $resp];
}

echo "Base URL: $base\n";
$cookie = sys_get_temp_dir() . '/cf_test_cookies.txt';
@unlink($cookie);

$all_ok = true;

// Step 1: Open home page
list($info, $body) = http_get($base . '/index.php', $cookie);
echo "[1] GET /index.php -> HTTP {$info['http_code']}\n";
if ($info['http_code'] !== 200 || stripos($body, 'Bienvenue') === false) {
    echo "  -> FAIL: homepage not detected.\n";
    $all_ok = false;
} else {
    echo "  -> OK\n";
}

// Step 2: Click Formations
list($info, $body) = http_get($base . '/index.php?page=formations', $cookie);
echo "[2] GET ?page=formations -> HTTP {$info['http_code']}\n";
$count = preg_match_all('#<div class="formation">#', $body, $m);
if ($info['http_code'] !== 200 || $count < 1) {
    echo "  -> FAIL: formations list missing or empty (found $count entries).\n";
    $all_ok = false;
} else {
    echo "  -> OK (found $count formation entries)\n";
}

// Step 3: Click S'inscrire on first formation -> find first inscription link
if (preg_match('#index.php\?page=inscription&formation_id=(\d+)#', $body, $m)) {
    $formation_id = $m[1];
    $inscription_url = $base . '/index.php?page=inscription&formation_id=' . $formation_id;
    list($info, $body2) = http_get($inscription_url, $cookie);
    echo "[3] GET inscription (formation_id=$formation_id) -> HTTP {$info['http_code']}\n";
    if ($info['http_code'] === 200 && (stripos($body2, "Formulaire d'Inscription") !== false || stripos($body2, 'Formulaire d\'Inscription') !== false) && stripos($body2, 'selected') !== false) {
        echo "  -> OK (form prefilled)\n";
    } else {
        echo "  -> FAIL: inscription form not prefilled or not reachable.\n";
        $all_ok = false;
    }
} else {
    echo "[3] FAIL: could not find inscription link on formations page.\n";
    $all_ok = false;
}

// Step 4: Submit valid form -> expects redirect to paiement
if (!empty($formation_id)) {
    $post = [
        'nom' => 'TestNom',
        'prenom' => 'TestPrenom',
        'email' => 'test+' . time() . '@example.com',
        'formation_id' => $formation_id
    ];
    list($info, $resp) = http_post($base . '/index.php?page=inscription', $post, $cookie, false);
    echo "[4] POST inscription -> HTTP {$info['http_code']} Location: {$info['redirect_url']}\n";
    if ($info['http_code'] == 302 || stripos($resp, 'Location:') !== false) {
        echo "  -> OK (redirected to paiement)\n";
    } else {
        echo "  -> FAIL: form submission did not redirect.\n";
        $all_ok = false;
    }
}

// Follow to paiement page (with cookies)
list($info, $paybody) = http_get($base . '/index.php?page=paiement&id=' . (int)($info['redirect_url'] ? filter_var($info['redirect_url'], FILTER_SANITIZE_URL) : ''), $cookie);
// It's OK if the redirect_url parsing fails; instead fetch last URL from previous response header
if (stripos($resp, 'Location:') !== false) {
    if (preg_match('#Location:\s*(.*)#i', $resp, $loc)) {
        $locUrl = trim($loc[1]);
        if (strpos($locUrl, 'index.php?page=paiement') !== false) {
            echo "[4b] Redirect to paiement detected.\n";
        }
    }
}

// Attempt to find the inscription id from paiement link or form
if (preg_match('#index.php\?page=paiement&id=(\d+)#', $resp . $paybody, $m2)) {
    $insc_id = $m2[1];
} else {
    // try to extract numeric id from page body
    if (preg_match('#name="id" value="?(\d+)"?#', $paybody, $m2)) $insc_id = $m2[1];
}

// Step 5: Click Paiement réussi -> submit mode=ok
if (!empty($insc_id)) {
    list($info5, $resp5) = http_post($base . '/index.php?page=paiement&id=' . $insc_id, ['mode' => 'ok'], $cookie, false);
    echo "[5] POST paiement (mode=ok) -> HTTP {$info5['http_code']}\n";
    if ($info5['http_code'] == 302 || stripos($resp5, 'Location:') !== false) {
        echo "  -> OK (redirect to succes)\n";
    } else {
        echo "  -> FAIL: paiement did not redirect.\n";
        $all_ok = false;
    }
} else {
    echo "[5] SKIP: cannot locate inscription id for paiement.\n";
    $all_ok = false;
}

// Step 6: Follow to succes and click Accéder aux cours
// Follow Location header in previous response to get success page
$successUrl = null;
if (preg_match('#Location:\s*(.*)#i', $resp5 ?? '', $loc2)) {
    $successUrl = trim($loc2[1]);
}
if ($successUrl === null) {
    // attempt default
    $successUrl = $base . '/index.php?page=succes&id=' . ($insc_id ?? '');
} else {
    if (strpos($successUrl, 'http') !== 0) {
        // relative
        $successUrl = $base . '/' . ltrim($successUrl, '/');
    }
}
list($info6, $body6) = http_get($successUrl, $cookie);
echo "[6] GET succes -> HTTP {$info6['http_code']}\n";
if ($info6['http_code'] === 200 && stripos($body6, 'Accéder aux cours') !== false) {
    echo "  -> OK (success page with link)\n";
    // follow the cours link
    list($iC, $bC) = http_get($base . '/index.php?page=cours', $cookie);
    echo "  -> GET /?page=cours -> HTTP {$iC['http_code']}\n";
    if ($iC['http_code'] === 200 && stripos($bC, 'Accès aux cours') !== false) {
        echo "  -> OK (cours page accessible after payment)\n";
    } else {
        echo "  -> FAIL: cours page content missing.\n";
        $all_ok = false;
    }
} else {
    echo "  -> FAIL: success page/link missing.\n";
    $all_ok = false;
}

// Step 7: Try to access cours without session (fresh cookie file)
@unlink($cookie);
$cookie2 = sys_get_temp_dir() . '/cf_test_cookies2.txt';
@unlink($cookie2);
list($info7, $b7) = http_get($base . '/index.php?page=cours', $cookie2, false);
echo "[7] GET ?page=cours without session -> HTTP {$info7['http_code']}\n";
// If redirected to index.php, either a 302 or the body will contain 'Bienvenue' homepage
if ($info7['http_code'] === 200 && stripos($b7, 'Bienvenue') !== false) {
    echo "  -> OK (redirected/served homepage)\n";
} else if ($info7['http_code'] >= 300 && $info7['http_code'] < 400) {
    echo "  -> OK (HTTP redirect detected)\n";
} else {
    echo "  -> FAIL: unauth access to cours not prevented.\n";
    $all_ok = false;
}

// Step 8: Verify DB inscription statut_paiement = 'paye'
echo "[8] Checking DB for last inscription with statut_paiement = 'paye'...\n";
try {
    $pdo = new PDO('mysql:host=localhost;dbname=gestion_formations;charset=utf8mb4', 'root', '');
    $stmt = $pdo->query("SELECT id, nom, prenom, email, statut_paiement FROM inscriptions ORDER BY id DESC LIMIT 5");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $found = false;
    foreach ($rows as $r) {
        if ($r['statut_paiement'] === 'paye') {
            echo "  -> OK: found inscription id={$r['id']} statut_paiement=paye (" . $r['email'] . ")\n";
            $found = true;
            break;
        }
    }
    if (!$found) {
        echo "  -> FAIL: no recent inscription with statut_paiement = 'paye' found in DB.\n";
        $all_ok = false;
    }
} catch (Exception $e) {
    echo "  -> ERROR connecting to DB: " . $e->getMessage() . "\n";
    $all_ok = false;
}

if ($all_ok) {
    echo "\nALL TESTS PASSED\n";
    exit(0);
} else {
    echo "\nSOME TESTS FAILED\n";
    exit(2);
}

?>