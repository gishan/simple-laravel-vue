<template>
    <div class="d-flex flex-row" style="height: inherit;">
        <div class="side-nav d-flex flex-column">
            <router-link class="p-2" to="/home">Dashboard</router-link>
            <router-link class="p-2" to="/employee">Employee Management</router-link>
            <router-link class="p-2" to="/system">System Management</router-link>
            <router-link class="p-2" to="/user">User</router-link>
        </div>
            <!-- use router-link component for navigation. -->
            <!-- specify the link by passing the `to` prop. -->
            <!-- `<router-link>` will be rendered as an `<a>` tag by default -->
       
        <router-view></router-view>
    </div>
</template>

<script>
export default {

}
</script>

<style>
.side-nav {
    max-width: 200px;
    background-color: wheat;
    height: 100%;
}
</style>