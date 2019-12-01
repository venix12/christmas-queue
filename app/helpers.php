<?php

function usergroup_badge($group) {
    $groups = ['ambassador', 'modder', 'nominator'];

    if(in_array($group, $groups)) {
        $badge = '<div class="usergroup-badge usergroup-badge--'.$group.'"></div>';
    }

    return $badge ?? '';
}