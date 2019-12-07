import React from 'react';

export const usergroupBadge = (group) => {
    let badge;
    const groups = ['ambassador', 'modder', 'nominator'];

    if(groups.includes(group)) {
        badge = <span className={`usergroup-badge usergroup-badge--${group}`} />
    }

    return badge;
}