<template>
    <div class="window">
        <div class ="title">Dodaj zdarzenie</div>
        <div class="btn-close">
            <div class="btn_sign" v-on:click="closePopup()">X</div>
        </div>
        <div id="data" class="col-sm-12 col-md-12 col-lg-12 data">
            <div class="col-sm-12 col-md-4 col-lg-4 data_input">
                <label for="description">Opis</label>
                <textarea type="text" id="description" v-model="description"></textarea>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4 data_input">
                <label for="date">Data</label>
                <input type="datetime-local" id="date" v-model="date">
            </div>
        </div>
        <button class="btn_common" v-on:click="addSchedule()">Dodaj Zdarzenie</button>
    </div>

</template>

<script>
import axios from "axios";
import schedule from "./schedule";
export default {
    name: "addSchedule",
    data() {
        return {
            description: null,
            date: null,
        }
    },
    props: {
        companyId: null,
    },
    methods: {
        closePopup() {
            this.$emit('closePopup');
        },
        addSchedule() {
            console.log(schedule.data().showAddScheduleModal);
            let data = {date: this.date, companyId: this.companyId, description: this.description};
            console.log(data);
            axios
                .post('schedule/addSchedule', data,{
                    headers: {'Content-Type': 'application/json'}
            })
                .then(response => {
                    console.log('success');
                    console.log(response);
                })
                .catch(error => {
                    console.log(error);
                })
        }
    }
}
</script>

<style scoped>
@media(min-width:1136px) and (max-width: 1455px) {
    .window {
        margin-left: 385px !important;
    }
}

@media(max-width: 1135px) {
    .window {
        margin-left: 200px !important
    }
}
@media (max-width: 750px) {
    .window {
        width: 500px;
    }
}

.window {
    margin-left: 430px;
    margin-top: 110px;
    padding-bottom: 30px;
    z-index: 2;
    transition: opacity .3s ease;
    background-color: white;
    position: fixed;
    border: black;
    border-style: solid;
    border-width: thin;
    border-bottom-right-radius: 10px;
    border-bottom-left-radius: 10px;
}
.title {
    height: 30px;
    background-color: #AAAAAA;
    text-align: center;
}
.btn-close {
    position: absolute;
    width: 30px;
    height: 30px;
    background: #af0530;
    top: 0;
    right: 0;
    color: #fff;
    border-top-right-radius: 2px;
    cursor: pointer;
    transition: background 0.25s;
}

.btn_sign {
    padding-left: 10px;
    padding-top: 7px;
}
.data {
    padding-left: 10px;
    padding-top: 10px;
}
.data_input {
    display: inline;
    float: left;
    padding-right: 10px;
}
</style>