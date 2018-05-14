'use strict';

/** Helper class for Errors **/

class User  {

    constructor(){
        this.id = '';

        this.name =  '';

        this.email = '';

        this.username = '';

        this.blocked = 0;

        this.reason_blocked = '';

        this.type = 0;

        this.total_forum_post = 0;

        this.total_forum_comments = 0;

        this.avatar = 'img/avatars/empty.png';

        this.access_token = '';
    }

    set(field, value){

        this[field] = value;
    }

    get(field){

        if(this[field]) {
            return this[field];
        }
    }

    parse(auth_user)
    {   
        this.id = auth_user.id;
        this.name = auth_user.name;
        this.email = auth_user.email;
        this.username = auth_user.username;
        this.type = auth_user.type;
        this.blocked = auth_user.blocked;
        this.reason_blocked = auth_user.reason_blocked;
        this.avatar = auth_user.avatar;
    }
    
    logged()
    {
        return (this.access_token != '' ? true : false);
    }

};

module.exports = User;