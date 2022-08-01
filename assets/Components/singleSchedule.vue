<template>
<div>
    <div class="schedule">
        <div class ="text_date">
            {{date}}
            {{data}}
        </div>
    </div>
</div>
</template>

<script>
export default {
    name: "singleSchedule",
    props: {
        date: String,
        data: null,
        seq: Number,
    },
    data() {
        return {
        }
    },
    created() {
        console.log('singleSchedule');
        console.log(this.data);
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
</style>
