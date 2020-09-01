class User {
    static getFromSessionStorage() {
        let stored = sessionStorage.getItem('user');

        if (stored) {
            return User.convertFromObject(JSON.parse(stored));
        }
    }

    static convertFromObject(toConvert) {
        let user = new User();
        for (let property of Object.keys(toConvert)) {
            user[property] = toConvert[property];
        }
        return user;
    }
}
