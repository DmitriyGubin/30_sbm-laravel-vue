<script>
import axios from 'axios';

export default {
    props: ['id_popup','all_sects'],
    emits: ['Сhoice_Tech'],
    data() {
        return {
            sects: [],
            first_sects: [],
            cur_sect: '',
            counter: 1,
            columns: ['type', 'char_one', 'char_two', 'char_three'],
            result: [],
            price: '',
            min_hour: '',
            search: ''
        }
    },
    methods: {
        Get_Sects: function () {
            axios.post('/tech_sect_list').then(res => {
                this.sects = res.data;
                this.first_sects = res.data;
            });
        },
        Fill_Sect: function (sec_name) {
            this.result.push(sec_name);
            this.cur_sect = sec_name;
            let post = {names: this.result, cur_column: this.columns[this.counter], columns: this.columns};
            axios.post('/tech_sub_sect_list', post).then(res => {
                this.search = '';
                if(res.data.close == 'no')
                {
                    this.counter++;
                    let data = res.data.sects;
                    if(data.length == 1 && data[0] == '')
                    {
                        this.Fill_Sect('пропуск');
                    }
                    else
                    {
                        this.sects = data;
                        this.cur_sect = 'no_no_no';
                    }
                }
                else
                {
                    $.fancybox.close();
                    $('#tech_inp_vue').val(this.full_name);
                    if(this.$parent)
                    {
                        this.$emit('Сhoice_Tech',this.full_name);
                    }
                    this.price = res.data.sects[0].price_nds;
                    this.min_hour = res.data.sects[0].min_hour;
                    //очиска
                        this.sects = this.first_sects;
                        this.cur_sect = '';
                        this.counter = 1;
                        this.result = [];
                    //очиска
                }
            });
        }
    },
    computed:
    {
        full_name() {
            let str = '';
            for(let item of this.result)
            {
                if(item != 'пропуск' && item != '')
                {
                    str = str + item + '; ';
                }
            }
            str = str.substring(0, str.length-2);
            return str;
        }
    },
    beforeMount() {
        if(this.all_sects == undefined)
        {
            this.Get_Sects();
        }
        else
        {
            this.sects = this.all_sects;
            this.first_sects = this.all_sects;
        }
    }
}

</script>

<template>

    <div class="univers_popup tech_popup" style="display: none;" :id="id_popup == undefined ? 'tech_popup' : 'tech_popup_'+id_popup">  
        <div class="pop_title">{{ full_name == '' ? 'Выберите технику' : full_name }}</div>
        <input v-model="search" type="text" placeholder="Поиск по названию">
        <div class="sect_list">
            <template v-for="item in sects" :key="(new Date()).getTime()">
                <div v-show="search == '' ? true : (item.toLowerCase()).includes(search.toLowerCase())" class="sect_item">
                    <input @click="Fill_Sect(item);" type="checkbox" class="galka" :checked="item == cur_sect">
                    <label class="sect_name">{{ item == '' ? 'другое' : item }}</label>
                </div>
            </template>
        </div>
    </div>

    <div v-show="price != ''" class="remark_price">Стоимость с НДС, руб/час: {{ price }}</div>
    <div v-show="min_hour != ''" class="remark_price">
        Минимальный заказ, ч: 
        <span id="min_hour_order">{{ min_hour }}</span>
    </div>

</template>
