import React from 'react';
import { usergroupBadge } from './usergroup-badge';

export const UserCard = (props) => {
    const { osu_id, username, user_title} = props;
    return (
        <div className="user-card">
            <img className="user-card__avatar" src={`https://a.ppy.sh/${osu_id}`} />

            <div className="user-card__info">
                <a className="user-card__link" href={`${osuBaseUrl}/u/${osu_id}`}>{username}</a>
                {user_title && usergroupBadge(user_title.toLowerCase())}
            </div>
        </div>
    );
}
