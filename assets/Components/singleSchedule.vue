<template>
<div>
    <div v-on:click="setShowScheduleDescription"
        class="schedule" v-bind:class="{'no_data': data.id === null || data.id === undefined }">
        <div class ="text_date">
            {{date}}
            {{showDescription}}
        </div>
    </div>
</div>
</template>

<script>
import ScheduleDescription from "./scheduleDescription";
import {eventBus} from "../schedule";
export default {
    name: "singleSchedule",
    components: {ScheduleDescription},
    data() {
        return {
            hasData: false,
            showDescription: false,
        }
    },
    props: {
        date: String,
        data: null,
        seq: Number,
        openNewDescription: true,
    },
    methods: {
        setShowScheduleDescription() {
            this.showDescription = !this.showDescription;
            if (this.showDescription) {
                eventBus.$emit('descriptionData', this.data)
            }
        },
    }
}
</script>

<style scoped>

@media (max-width: 984px) {
    .schedule {
        width: 220px!important;
        height: 180px!important;
    }
    .text_date {
        padding-top: 80px!important;
        font-size: larger;
    }
}


.schedule {
    height: 100px;
    width:150px;
    background-color: cadetblue;
    margin-right: 10px;
    margin-top: 10px;
}
.text_date{
    text-align: center;
    padding-top: 30px;
}
.no_data {
    background-color: red;
}
</style>
