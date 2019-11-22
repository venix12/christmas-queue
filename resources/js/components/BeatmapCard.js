import React, { Component } from 'react';
import Modal from './Modal';
import { getMods, getNominators, currentUser } from '../helpers/RestApi';
import Status from './Status';

class BeatmapCard extends Component {
    state = {
        approved: this.props.approved,
        deleted: this.props.deleted,
        modal: false,
        mods: [],
        nominators: [],
        nominated: true,
        modded: true
    }

    async componentDidMount() {
        $('[data-toggle="tooltip"]').tooltip({
            trigger: 'hover'
        });

        const { currentUser, id } = this.props;

        const mods = await getMods(id);
        const nominators = await getNominators(id);
        const nominated = Boolean(nominators.find(x => x.user.id === currentUser.id));
        const modded = Boolean(mods.find(x => x.user.id === currentUser.id));

        this.setState({
            mods: mods,
            nominators: nominators,
            nominated: nominated,
            modded: modded
        });
    }

    approveBeatmap = () => {
        const { id } = this.props;
        axios.post('beatmap-approve', { beatmap_id: id });

        this.setState({
            approved: true
        });
    }

    becomeModder = async (type) => {
        const { id } = this.props;

        const response = await axios.post('beatmaps/add-modder', { beatmap_id: id, type: type });
        const mod = response.data[0].type === 0;

        if(response.data === 'error') {
            return 0;
        } else if(mod) {
            this.setState(prevState => ({
                mods: prevState.mods.concat(response.data),
                modded: true
            }));
        } else {
            this.setState(prevState => ({
                nominators: prevState.nominators.concat(response.data),
                nominated: true
            }));
        }
    }

    openModal = () => {
        this.setState({
            modal: true
        });
    }

    closeModal = () => {
        this.setState({
            modal: false
        });
    }

    deleteBeatmap = () => {
        const { id } = this.props;
        axios.post('beatmap-delete', { beatmap_id: id });

        this.setState({
            deleted: true
        });
    }

    removeModder = async (type) => {
        const { id } = this.props;
        const { mods, nominators } = this.state;

        const response = await axios.post('beatmaps/remove-modder', { beatmap_id: id, type: type });
        const mod = response.data.type === 0;

        if(response.data === 'error') {
            return 0;
        } else if(mod) {
            this.setState({
                mods: mods.filter(x => x.id !== response.data.id),
                modded: false
            });
        } else {
            this.setState({
                nominators: nominators.filter(x => x.id !== response.data.id),
                nominated: false
            })
        }
    }

    restoreBeatmap = () => {
        const { id } = this.props;
        axios.post('beatmap-restore', { beatmap_id: id });

        this.setState({
            deleted: false,
            approved: true
        });
    }

    modal = () => {
        const { beatmap_id, creator, currentUser, metadata } = this.props;
        const { mods, nominators, nominated, modded } = this.state;
        return (
            <Modal
                onClose={this.closeModal}
                bgImg={`https://assets.ppy.sh/beatmaps/${beatmap_id}/covers/cover.jpg`}
                header={
                    <a class="beatmap-card__badge round-text text-left" href={`https://osu.ppy.sh/s/${beatmap_id}`}>
                        {metadata} <br />
                        <small>mapped by {creator}</small>
                    </a>
                }
            >
                <div>
                    <span class="color--lightblue">Modders</span> ({mods.length}):
                    {mods.map((mod, index) => {
                        return <span key={index}> {mod.user.username},</span>
                    })}
                </div>

                <div>
                    <span class="color--pink">Potential nominators</span> ({nominators.length}):
                    {nominators.map((nominator, index) => {
                        return <span key={index}> {nominator.user.username},</span>
                    })}
                </div>

                <br />

                {(currentUser.isModder && !modded) &&
                    <div>
                        <button class="button bg--green" onClick={ () => this.becomeModder(0) }>
                            <i class="fa fa-plus"></i> Mark yourself as a modder
                        </button>
                        <br /> <br />
                    </div>
                }

                {(currentUser.isModder && modded) &&
                    <div>
                        <button class="button bg--orange" onClick={ () => this.removeModder(0)}>
                            <i class="fa fa-minus"></i> Remove yourself from modders
                        </button>
                        <br /> <br />
                    </div>
                }

                {(currentUser.isNominator && !nominated) && <button class="button bg--pink" onClick={ () => this.becomeModder(1) }><i class="fa fa-plus"></i> Mark yourself as a potential nominator</button>}
                {(currentUser.isNominator && nominated) && <button class="button bg--orange" onClick={ () => this.removeModder(1) }><i class="fa fa-minus"></i> Remove yourself from potential nominators</button>}
                {!currentUser.id &&
                    <div className="text-center">
                        <Status status="error" message="You have to be logged in to perform actions!" />
                    </div>
                }
            </Modal>
        );
    }

    render() {
        const { currentUser, creator, beatmap_id, metadata, modes } = this.props;
        const { approved, deleted } = this.state;
        return (
            <React.Fragment>
                {this.state.modal && this.modal()}

                <div
                class="beatmap-card text-left"
                style={{
                    backgroundImage: `url(https://assets.ppy.sh/beatmaps/${beatmap_id}/covers/cover.jpg)`
                }}
                >
                    <a class="beatmap-card__badge" href={`https://osu.ppy.sh/s/${beatmap_id}`}>
                        {metadata} <br />
                        <small>mapped by {creator}</small> <br />
                    </a> <br />
                    <div>
                        <div class="float-left">
                            <button
                                onClick={this.openModal}
                                class="button button--circle bg-primary"
                                data-placement="bottom"
                                data-toggle="tooltip"
                                title="Details"
                            >
                                <i class="fa fa-navicon"></i>
                            </button>

                            <div
                                class="beatmap-card__info beatmap-card__info--modders"
                                title="Modders"
                                data-placement="bottom"
                                data-toggle="tooltip"
                            >
                                <span>{this.state.mods.length}</span>
                            </div>

                            <div
                                class="beatmap-card__info beatmap-card__info--nominators"
                                title="Potential nominators"
                                data-placement="bottom"
                                data-toggle="tooltip"
                            >
                                <span>{this.state.nominators.length}</span>
                            </div>

                            <div
                                class="beatmap-card__info beatmap-card__info--modes"
                                title="Gamemodes"
                                data-placement="bottom"
                                data-toggle="tooltip"
                            >
                                {modes.map(mode => {
                                    return <span key={mode.name}>{mode.bool && <span>{mode.name} </span>}</span>
                                })}
                            </div>
                        </div>
                        <div class="float-right">
                            {(deleted == false && (currentUser.isAmbassador && approved == false)) &&
                                <button
                                    onClick={this.approveBeatmap}
                                    class="button button--circle bg-success"
                                    data-toggle="tooltip"
                                    title="Approve">
                                    <i class="fa fa-check"></i>
                                </button>}
                            {(currentUser.isAmbassador && deleted == false) &&
                                <button
                                    onClick={this.deleteBeatmap}
                                    class="button button--circle bg--red"
                                    data-toggle="tooltip"
                                    title="Delete">
                                    <i class="fa fa-trash"></i>
                                </button>}
                            {(currentUser.isAmbassador && deleted == true) &&
                                <button
                                    onClick={this.restoreBeatmap}
                                    class="button button--circle bg-warning"
                                    data-toggle="tooltip"
                                    title="Restore">
                                    <i class="fa fa-refresh"></i>
                                </button>}
                        </div>
                    </div>
                </div>
            </React.Fragment>
        );
    };
}

export default BeatmapCard;
