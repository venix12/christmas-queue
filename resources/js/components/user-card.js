import React from 'react';
import { usergroupBadge } from './usergroup-badge';

export const UserCard = (props) => {
    const { osu_id, username, user_title} = props;
    return (
        <div className="user-card text-left">
            <img className="user-card__avatar" src={`https://a.ppy.sh/${osu_id}`}></img>
            <a className="user-card__link" href={`https://osu.ppy.sh/u/${osu_id}`}>{username}</a><br></br>
            {user_title && usergroupBadge(user_title.toLowerCase())}
        </div>
    );
}