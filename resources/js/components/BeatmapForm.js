import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import Modal from './Modal';
import Status from './Status';

export default class BeatmapForm extends Component {
    state = {
        beatmapsetId: '',
        message: '',
        modal: false,
        status: '',
    }

    beatmapParse = (url) => {
        let split;

        if(url.includes('/beatmapsets/')) {
            const a = url.split('/beatmapsets/');
            split = a[1].split('#');
            return split[0];
        } else if(url.includes('/s/')) {
            split = url.split('/s/');
            return split[1];
        } else if(url.includes('/b/')) {
            return 'wrong_link';
        }
    }

    changeHandler = (e) => {
        this.setState({
            [e.target.name]: e.target.value
        });
    }

    submitHandler = async (e) => {
        e.preventDefault();
        let { beatmapsetId } = this.state;

        const checkbox = document.getElementById('box');

        if(!checkbox.checked) {
            const status = 'error';
            const message = 'You have to accept the rules to request a beatmap!';

            this.setState({
                message: message,
                status: status
            })

            return 0;
        }

        try {
            var parser = await this.beatmapParse(beatmapsetId);

            if(parser === 'wrong_link') {
                const status = 'error';
                const message = '/b/ links are not supported, you should use the /s/ one instead!';

                this.setState({
                    message: message,
                    status: status
                })

                return 0;
            }
        } catch (err) {
            const status = 'error';
            const message = 'Seems like the URL format is wrong...';

            this.setState({
                message: message,
                status: status
            })

            return 0;
        }

        beatmapsetId = parser;

        let message;
        let status;

        const data = {
            beatmapsetId: beatmapsetId,
        }

        const res = await axios.post('beatmaps', data);
        try {
            if(typeof(res.data.error) !== 'undefined') {
                status = 'error';
                message = res.data.error;
            } else {
                status = 'success';
                message = 'Your beatmap has been sent for approval!';
            }

            this.setState({
                beatmapsetId: '',
                message: message,
                status: status,
            });

        } catch(err) {
            status = 'error';
            message = 'Seems like something went wrong...';

            this.setState({
                beatmapsetId: '',
                message: message,
                status: status,
            });
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

    modal = () => {
        return(
            <Modal
                onClose={this.closeModal}
                header={<h1 class="display-4">Christmas Queue Rules</h1>}
            >
                <ul>
                    <li>The map must relate to Christmas, Winter, or the New Year.</li>
                    <li>The request is made before the New Year (the queue will close then).</li>
                    <li>You have participated in the creation of the map.</li>
                    <li>You are using a Christmas avatar! (we will be too!)</li>
                    <li>Each user can only request one map.</li>
                    <li>If your request was invalid, you can make a new one.</li>
                </ul>
            </Modal>
        );
    }

    render() {
        const { beatmapsetId, message, modal, status } = this.state;
        return (
            <div>
                {modal && this.modal()}
                <form onSubmit={this.submitHandler}>
                    <div class="form-wrapper">
                        <input
                            autoComplete="off"
                            class="input-invisible"
                            type="text"
                            name="beatmapsetId"
                            value={beatmapsetId}
                            onChange={this.changeHandler}
                            required
                        />
                        <button class="button bg--blue" type="submit"><i class="fa fa-check"></i> Request!</button>
                    </div> <br />

                    <small class="color--gray">please put only <b>beatmapset</b> URL here</small> <br />

                    <input id="box" type="checkbox" />
                    <label for="box" class="color--lightgray">my map meets <a href="#" onClick={this.openModal}>the rules</a></label>
                </form>
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
