import React, { Component } from 'react';
import { usergroupBadge } from './usergroup-badge';

class UserPanel extends Component {
    state = {
        groups: [],
        loaded: false
    }

    componentDidMount() {
        const { user } = this.props;
        const { groups } = this.state;

        if(user.isAmbassador) {
            groups.push('ambassador');
        }

        if(user.isModder) {
            groups.push('modder');
        }

        if(user.isNominator) {
            groups.push('nominator');
        }

        this.setState({ loaded: true });
    }

    render() {
        const { user } = this.props;
        const { groups, updated, loaded } = this.state;
        return (
            <div className="user-listing__bg">
                <div className="user-listing__card">
                    <div>
                        <img className="user-listing__avatar" src={`https://a.ppy.sh/${user.osu_id}`} />
                        <a href={`${osuBaseUrl}/users/${user.osu_id}`} class="user-listing__el user-listing__el--link">{user.username}</a>

                        {loaded === true && groups.map(group => {
                            return <span className="user-listing__el">{usergroupBadge(group)}</span>
                        })}

                        {updated && <span className="color--green">updated!</span>}
                    </div>
                </div>
            </div>
        )
    }
}

export default UserPanel;
