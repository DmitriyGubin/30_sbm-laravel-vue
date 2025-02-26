<script>

import axios from 'axios';
import Role from './role.vue';

export default {
    components: {
        Role
    },

    data() {
        return {
            data: null
        }
    },

    methods: {
        Get_Data: function () {
            axios.post('/get_roles').then(res => {
                this.data = res.data;
                for (let role of this.data) 
                {
                    for (let user of role.users) 
                    {
                        if(user.activity == 1)
                        {
                            user.activity = true;
                        }
                        else
                        {
                            user.activity = false;
                        }
                    }
                }
            })
        },
        Remove_User: function (id) {
            let post_data = { id_user: id };
            axios.post('/delete_user', post_data).then(res => {
                console.log(res.data);
                for (let role of this.data) {
                    role.users = role.users.filter(user => {
                        return user.id !== id;
                    });

                    if (role.users.length == 0) {
                        let cur_id = role.id;
                        this.data = this.data.filter(role => {
                            return role.id !== cur_id;
                        });
                    }
                }
            });
        },
        Make_Activ: function (id) {
            
            let post_data = {
                id: id,
                activity: 1
            };

            axios.post('/save_user', post_data).then(res => {
                console.log(res.data);
                for (let role of this.data) 
                {
                    for (let user of role.users) 
                    {
                        if (user.id == id) 
                        {
                            user.activity = true;
                            break;
                        }
                    }
                }
            });
        }
    },

    beforeMount() {
        this.Get_Data();
    }
}

</script>


<template>
    <Role v-for="item in data" 
    :key="item.id" 
    :elem="item" 
    @remove_user="Remove_User" 
    @make_activ="Make_Activ" />
</template>
