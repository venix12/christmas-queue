import axios from 'axios';

export const currentUser = async() => {
    const response = await axios.get('api/current-user');
    const data = await response.data;
    return data;
}

export const getMods = async(id = 'all') => {
    let response;

    switch(id) {
        case 'all':
            response = await axios.get('api/mods');
            break;

        default:
            response = await axios.get(`api/mods/${id}`);
            break;
    }

    const data = await response.data;
    return data;
}

export const getNominators = async(id = 'all') => {
    let response;

    switch(id) {
        case 'all':
            response = await axios.get('api/nominators');
            break;

        default:
            response = await axios.get(`api/nominators/${id}`);
            break;
    }

    const data = await response.data;
    return data;
}