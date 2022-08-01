<template>
    <div>

        <form method="POST" action="/login">
            <label for="login">Użytkownik</label>
            <input type="text" name="login" id="login">
            <label for="password">Hasło</label>
            <input type ="text" name ="password" id="password">
            <input type="hidden" name="_csrf_token_login" :value= csrfAuth >
            <button type="submit">zaloguj</button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    name: "home",
    data() {
        return {
            csrfAuth: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
           // errors: errors,
        }
    },
    created() {
        console.log(this.errors);
        for (let i = 0; i<8; i++) {
            if (i > 4) {
                break;
            }
             console.log(i);
        }
        console.log(326);

    },

    methods: {
        checkLoop() {

        }
    }
}

</script>

<style scoped>

</style>