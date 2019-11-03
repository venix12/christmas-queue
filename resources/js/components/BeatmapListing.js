import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import BeatmapCard from './BeatmapCard';
import { currentUser } from '../helpers/RestApi';

export default class BeatmapListing extends Component {
    constructor(props) {
        super(props);
        this.state = {
            currentUser: {},
            loading: true,
        }
    }

    async componentDidMount() {
        const res = await currentUser();
        this.setState({
            currentUser: res,
            loading: false
        })
    }

    beatmapList = currentUser => {
        const { data } = this.props;
        return (
            <div>
                {data.map(beatmap => {
                    return <BeatmapCard
                        approved={beatmap.approved}
                        beatmap_id={beatmap.beatmapset_osu_id}
                        creator={beatmap.beatmapset_creator}
                        currentUser={currentUser}
                        deleted={beatmap.deleted}
                        id={beatmap.id}
                        key={beatmap.id}
                        metadata={`${beatmap.beatmapset_artist} - ${beatmap.beatmapset_title}`}
                    />
                })}
            </div>
        );
    }

    render() {
        const { currentUser, loading } = this.state;
        return(
            <div>{!loading && this.beatmapList(currentUser)}</div>
        )
    }
}

const element = 'beatmap-listing';

if (document.getElementById(element)) {
    const data = JSON.parse(document.getElementById(element).getAttribute('data'));
    ReactDOM.render(<BeatmapListing data={data} />, document.getElementById(element));
}

if (document.getElementById(`${element}2`)) {
    const data = JSON.parse(document.getElementById(`${element}2`).getAttribute('data'));
    ReactDOM.render(<BeatmapListing data={data} />, document.getElementById(`${element}2`));
}