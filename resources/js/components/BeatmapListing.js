import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import BeatmapCard from './BeatmapCard';

const modes = ['osu', 'taiko', 'mania', 'catch'];

export default class BeatmapListing extends Component {
    constructor(props) {
        super(props);
        this.state = {
            currentFilter: '',
            data: this.props.data,
        }
    }

    modeSwitcher = (mode) => {
        const { data } = this.props;
        const { currentFilter } = this.state;

        const dataFiltered = data.filter(x => x[mode] === true);
        const alreadyFiltered = this.state.data.sort().join(', ') === dataFiltered.sort().join(', ') && currentFilter === mode;

        if(!alreadyFiltered) {
            this.setState({
                currentFilter: mode,
                data: dataFiltered
            })
        } else {
            this.setState({
                currentFilter: '',
                data: data
            })
        }
    }

    modeFilter = () => {
        const { currentFilter } = this.state;
        return(
            <div class="nav__bg" style={{marginTop: '6px'}}>
                {modes.map(mode => {
                    return <span key={mode}>
                        <a href="#" class={ currentFilter === mode ? 'nav__el nav__el--current' : 'nav__el' } onClick={() => this.modeSwitcher(mode)}>
                            {mode}!
                        </a>
                    </span>
                })}
            </div>
        )
    }

    render() {
        const { filters } = this.props;
        const { data } = this.state;
        return (
            <div>
                {filters && <div>{this.modeFilter()}<br /></div>}

                {data.map(beatmap => {
                    return <BeatmapCard
                        approved={beatmap.approved}
                        beatmap_id={beatmap.beatmapset_osu_id}
                        creator={beatmap.beatmapset_creator}
                        deleted={beatmap.deleted}
                        id={beatmap.id}
                        key={beatmap.id}
                        metadata={`${beatmap.beatmapset_artist} - ${beatmap.beatmapset_title}`}
                        modes={[
                            { name: 'osu!', bool: beatmap.osu },
                            { name: 'taiko!', bool: beatmap.taiko },
                            { name: 'mania!', bool: beatmap.mania },
                            { name: 'catch!', bool: beatmap.catch }
                        ]}
                    />
                })}
            </div>
        );
    }
}

const element = 'beatmap-listing';

if (document.getElementById(element)) {
    const data = JSON.parse(document.getElementById(element).getAttribute('data'));
    const filters = document.getElementById(element).getAttribute('filters');
    ReactDOM.render(<BeatmapListing data={data} filters={filters}/>, document.getElementById(element));
}

if (document.getElementById(`${element}2`)) {
    const data = JSON.parse(document.getElementById(`${element}2`).getAttribute('data'));
    ReactDOM.render(<BeatmapListing data={data} />, document.getElementById(`${element}2`));
}