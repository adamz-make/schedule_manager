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


         <div class="row" v-on:click="testMethod">
            <single-schedule  v-if="scheduleForDays !== undefined && scheduleForDays !== null"
                             v-for="(dayData, index, key) in scheduleForDays"
                              :date="index" :data="dayData" :key="key" :openNewDescription="test"
                              @closeDescriptionData="showDescriptionData=false"
                             style="float:left">
            </single-schedule>
        </div>
        <schedule-description
            v-if="this.descriptionData !== undefined && this.descriptionData !== null && showDescriptionData"
            :data="this.descriptionData">

        </schedule-description>
        <add-schedule @closePopup="showAddScheduleModal=false" v-if="showAddScheduleModal" :company=companyId ></add-schedule>
    </div>
</template>

<script>
import singleSchedule from "./singleSchedule";
import axios from "axios";
import AddSchedule from "./addSchedule";
import scheduleDescription from "./scheduleDescription";
import {eventBus} from "../schedule";

export default {
    name: "schedule",
    components: {
        AddSchedule,
        singleSchedule,
        scheduleDescription
    },
    data() {
        return {
            companiesList: JSON.parse(companies),
            scheduleForDays: null,
            selectedYear: null,
            selectedMonth: null,
            showAddScheduleModal: false,
            companyId: null,
            test: false,
            showDescriptionData: true,
            descriptionData: null,
        }
    },
    created() {
        let currentDay = new Date();
        this.selectedYear = currentDay.getUTCFullYear();
        this.selectedMonth = currentDay.getUTCMonth() + 1;
    },
    mounted() {
        console.log(this.descriptionData);
        eventBus.$on('descriptionData', (descriptionData) => {
            this.showDescriptionData = true;
            this.descriptionData = descriptionData;
        })
    },
    methods: {
        testMethod() {
            this.test = !this.test;
        },
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
                    this.scheduleForDays = JSON.parse(scheduleFordays);
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