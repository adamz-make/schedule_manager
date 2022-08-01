<template>
    <div>
        <div class="row">
            <select
                id="month"
                v-on:change="getSchedule()"
                v-model ="selectedMonth"
            >
                <option value=1>Styczeń</option>
                <option value=2>Luty</option>
                <option value=3>Marzec</option>
                <option value=4>Kwiecień</option>
                <option value=5>Maj</option>
                <option value=6>Czerwiec</option>
                <option value=7>Lipiec</option>
                <option value=8>Sierpień</option>
                <option value=9>Wrzesień</option>
                <option value=10>Październik</option>
                <option value=11>Listopad</option>
                <option value=12>Grudzień</option>
            </select>
            <select id="year"
                    v-model = selectedYear
                    v-on:change="getSchedule()">
                <option v-for ="index in 6">
                    {{selectedYear - 6 + index}}
                </option>
                <option v-for ="index in 6">
                    {{selectedYear - 0 + index}}
                </option>
            </select>
            <label for="company_id">Firma</label>
            <select id="company_id"
                    v-model="companyId"
                    v-on:change="getSchedule()">
                <option value=null>Wybierz</option>
                <option v-for="company in companiesList" :value="company.id">
                    {{company.companyName}}
                </option>
            </select>
            <button class="btn_common" v-on:click="addSchedule">Dodaj wydarzenie</button>
            <div v-if="scheduleForDays != null">
                 {{scheduleForDays}}
             </div>
        </div>

        <!--
        <div class="row">
            <single-schedule v-if="scheduleForDays !== undefined && scheduleForDays !== null"

                             v-for="(daydata, index, key) in scheduleForDays" :date="index" :data="JSON.parse(daydata)" :key="key"
                             style="float:left">
            </single-schedule>
        </div>!-->

        <add-schedule @closePopup="showAddScheduleModal=false" v-if="showAddScheduleModal" :company=companyId ></add-schedule>
    </div>
</template>

<script>
import singleSchedule from "./singleSchedule";
import axios from "axios";
import AddSchedule from "./addSchedule";

export default {
    name: "schedule",
    components: {
        AddSchedule,
        singleSchedule,
    },
    data() {
        return {
            companiesList: JSON.parse(companies),
            scheduleForDays: null,
            selectedYear: null,
            selectedMonth: null,
            showAddScheduleModal: false,
            companyId: null,
        }
    },
    created() {
        let currentDay = new Date();
        this.selectedYear = currentDay.getUTCFullYear();
        this.selectedMonth = currentDay.getUTCMonth() + 1;
    },

    methods: {
        getSchedule() {
            if ( this.companyId == null || this.companyId === undefined) {
                return;
            }
            let month = this.selectedMonth.toString();
            if (month.length === 1) {
                month = '0' + month;
            }
            let data = {date: this.selectedYear.toString() + '-' + month + '-' + '01', companyId: this.companyId};
            console.log(data);
            axios
                .post('schedule/getSchedule', data, {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    let scheduleFordays = response.data.scheduleForDays;
                    this.scheduleForDays = scheduleFordays;
                    console.log(this.scheduleForDays);
                })
                .catch(error => {
                    console.log(error);
                });
        },
        addSchedule() {
            this.showAddScheduleModal = true;
        }
    },
}
</script>

<style scoped>
.schedule_list{
    margin-top: 150px;
    margin-left: 150px;
    width :1000px;
}
</style>