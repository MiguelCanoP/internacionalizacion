<template>
    <v-list-group>
        <template v-slot:prependIcon>
            <v-icon color="#0f1f39">{{ icon }}</v-icon>
        </template>
        <template v-slot:activator>
            <v-list-item-content>
                <v-list-item-title class="text-justify">
                    {{ title }}
                </v-list-item-title>
                <v-list-item-subtitle>
                    {{ subtitle }}
                </v-list-item-subtitle>
            </v-list-item-content>
        </template>
        <v-list-item>
            <v-list-item-icon>
            </v-list-item-icon>
            <v-list-item-content>
                <v-list-item-title class="text-wrap text-justify custom-title">
                    {{ title }}
                </v-list-item-title>
            </v-list-item-content>
        </v-list-item>
        <v-divider inset></v-divider>
    </v-list-group>
</template>

<script>
export default {
    name: "AgreementCardCollapsableItem",
    props: {
        icon: String,
        title: String,
        subtitle: String,
    }
}
</script>

<style scoped>

</style>
