<template>
    <div class="container mt-3">
        <div class="row"  v-if="$gate.isSuperAdmin()">
            <div class="col-md-12">
               <passport-clients></passport-clients>
                <passport-authorized-clients></passport-authorized-clients>
                <passport-personal-access-tokens></passport-personal-access-tokens>
            </div>
        </div>
        <div v-if="!$gate.isSuperAdmin()" >
                <h3 class="text-center">Whoops.....You are not autherized to access this page?</h3>
                <not-found></not-found>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
