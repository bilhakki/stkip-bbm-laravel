import fetch from "../../../../helpers/fetch";

function isObject(value) {
    return Object.prototype.toString.call(value) === "[object Object]";
}

export default ({ method }) => {
    return {
        // storeHandler() {
        [`${method}Handler`]() {
            this.errors = null;
            let url;

            if (method === "store") {
                url = this.element.getAttribute("action");
            } else if (method === "update") {
                url = this.urlUpdate;
            }

            let body = {};
            Object.keys(this.body).forEach((key) => {
                const value = this.body[key];
                if (isObject(value)) {
                    const keys = Object.keys(value);
                    body[key] = value[keys[0]];
                } else {
                    body[key] = value;
                }
            });

            let fetchMethod;
            if (method === "store") fetchMethod = "POST";
            else if (method === "update") fetchMethod = "PUT";
            fetch(url, {
                method: fetchMethod,
                body,
            })
                .then((data) => {
                    this[`${method}Success`](data);
                })
                .catch((error) => {
                    console.log("🚀 ~ file: common.js:42 ~ error:", error)
                    const message = error.message;
                    let errors = [];
                    Object.keys(error.errors).forEach((key) => {
                        errors.push(error.errors[key]);
                    });
                    this.errors = {
                        message,
                        errors,
                    };
                });
        },
    };
};
