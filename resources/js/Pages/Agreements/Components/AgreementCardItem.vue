<template>
    <v-list-item>
        <v-list-item-icon>
            <v-icon color="#0f1f39">
                {{ icon }}
            </v-icon>
        </v-list-item-icon>
        <v-list-item-content>
            <v-list-item-title class="text-justify" :class="{'custom-title':uppercase}">
                {{ title }}
            </v-list-item-title>
            <v-list-item-subtitle>
                {{ subtitle }}
            </v-list-item-subtitle>
        </v-list-item-content>
    </v-list-item>
</template>

<script>
export default {
    name: "AgreementCardItem",
    props: {
        icon: String,
        title: String,
        subtitle: String,
        uppercase: Boolean,
    }
}
</script>

<style scoped>
.custom-title{
    text-transform:capitalize;
}
</style>
