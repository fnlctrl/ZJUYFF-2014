<?php
    echo 'hook';
    if (!isset($_GET["SenorsenHookFFF"])) {
        die("heypasswderror\n");
    }
    $mirrordir = '.';
    $gitdir = $mirrordir."/.git";
    $branch = 'stable';
    $json = file_get_contents('php://input');
    $jsarr = json_decode($json);
    $branch = $jsarr["ref"];
    if ($branch == 'refs/heads/' . $branch) {
        $cmd = "git --work-tree=$mirrordir --git-dir=$gitdir pull origin $branch";
        exec($cmd);
        echo '.1';
    }
    echo '.0';
