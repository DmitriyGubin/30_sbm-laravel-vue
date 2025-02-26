<script>

export default {
    props: ['item']
}

</script>

<template>
    <div class="order_item">
        
        <h2 class="order_title">
            {{ item.tech.type + ((item.tech.name == '') ? '' : ', '+item.tech.name) }}
        </h2>
        
        <div class="main_line three">
            <div class="ab_item" v-if="item.tech.char_one != ''">
                <div class="label">Характеристика 1:</div>
                <div class="result">{{ item.tech.char_one }}</div>
            </div>

            <div class="ab_item" v-if="item.tech.char_two != ''">
                <div class="label">Характеристика 2:</div>
                <div class="result">{{ item.tech.char_two }}</div>
            </div>

            <div class="ab_item" v-if="item.tech.char_three != ''">
                <div class="label">Характеристика 3:</div>
                <div class="result">{{ item.tech.char_three }}</div>
            </div>

            <div class="ab_item" v-if="item.tech.price_nds != ''">
                <div class="label">Ставка за час (с НДС):</div>
                <div class="result">{{ item.tech.price_nds }}</div>
            </div>

            <div class="ab_item" v-if="item.tech.min_hour != ''">
                <div class="label">Минимальное количество часов:</div>
                <div class="result">{{ item.tech.min_hour }}</div>
            </div>
        </div>
    </div>
</template>
