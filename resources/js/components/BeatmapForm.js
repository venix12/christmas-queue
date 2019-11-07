import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import { osuApi } from '../helpers/OsuApi';
import Status from './Status';

export default class BeatmapForm extends Component {
    state = {
        beatmapsetArtist: '',
        beatmapsetId: '',
        beatmapsetTitle: '',
        message: '',
        osuUserId: '',
        status: '',
    }

    changeHandler = (e) => {
        if(!isNaN(e.target.value)) {
            this.setState({
                [e.target.name]: e.target.value
            });
        }
    }

    submitHandler = (e) => {
        e.preventDefault();
        const { beatmapsetId } = this.state;

        osuApi('beatmap', beatmapsetId)
            .then(response => {
                let message;
                let status;

                if(typeof(response) === 'undefined') {
                    status = 'error';
                    message = 'Beatmapset not found... Make sure you put correct beatamapset ID!';
                    this.setState({
                        beatmapsetArtist: '',
                        beatmapsetCreator: '',
                        beatmapsetId: '',
                        beatmapsetTitle: '',
                        message: message,
                        osuUserId: '',
                        status: status,
                    });
                }

                this.setState({
                    beatmapsetArtist: response.artist,
                    beatmapsetCreator: response.creator,
                    beatmapsetTitle: response.title,
                    osuUserId: response.creator_id,
                });

                axios.post('/christmas-queue/public/beatmaps', this.state)
                    .then(res => {
                        if(typeof(res.data.error) !== 'undefined') {
                            status = 'error';
                            message = res.data.error;
                        } else {
                            status = 'success';
                            message = 'Your beatmap has been sent for approval!';
                        }

                        this.setState({
                            beatmapsetArtist: '',
                            beatmapsetCreator: '',
                            beatmapsetId: '',
                            beatmapsetTitle: '',
                            message: message,
                            osuUserId: '',
                            status: status,
                        });

                    })
                    .catch(err => {
                        status = 'error';
                        message = 'Seems like something went wrong...';

                        this.setState({
                            message: message,
                            status: status,
                        });
                    });
            }
        );
    }

    render() {
        const { beatmapsetId, message, status } = this.state;
        return (
            <div>
                <div class="form-wrapper">
                    <form onSubmit={this.submitHandler}>
                        <input
                            autoComplete="off"
                            class="input-invisible"
                            type="text"
                            name="beatmapsetId"
                            value={beatmapsetId}
                            onChange={this.changeHandler}
                        />
                        <button class="button bg-orange" type="submit"><i class="fa fa-check"></i> Request!</button>
                    </form>
                </div>
                <br />
                {status && <Status
                    message={message}
                    status={status}
                />}
            </div>
        );
    }
}

if (document.getElementById('beatmap-form')) {
    ReactDOM.render(<BeatmapForm />, document.getElementById('beatmap-form'));
}