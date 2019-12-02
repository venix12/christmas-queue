globals = {
    getElementAttribute(id, attribute) {
        const el = document.getElementById(id);
        const attr = el ? el.getAttribute(attribute) : null;

        return attr;
    },

    json(id) {
        const el = document.getElementById(id);
        const json = el ? JSON.parse(el.text) : null;

        return json;
    }
}