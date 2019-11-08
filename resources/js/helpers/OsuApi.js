export async function osuApi(type, id) {
    const apiToken = process.env.MIX_OSU_API_KEY;

    let api;

    switch(type) {
        case 'beatmap':
            api = `https://osu.ppy.sh/api/get_beatmaps?k=${apiToken}&s=${id}`;
            break;

        case 'user':
            api = `https://osu.ppy.sh/api/get_user?k=${apiToken}&u=${id}`;
            break;
    }


    try {
        const response = await fetch(api);
        const data = await response.json();
        return data;
    } catch(err) {
        console.log(err);
    }
}