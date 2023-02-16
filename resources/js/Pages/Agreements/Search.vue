<template>
    <v-app>
        <!-- Sizes your content based upon application components -->
        <v-main>
            <!-- Provides the application the proper gutter -->
            <v-container class="fill-height align-start">
                <v-card
                    class="mx-auto my-12"
                >
                    <v-card-title>Cafe Badilico</v-card-title>
                    <v-divider class="mx-4"></v-divider>
                </v-card>
            </v-container>
        </v-main>


    </v-app>

</template>

<script>
import Agreement from "@/models/Agreement";

export default {
    name: "Search",
    async created() {
        await this.getAgreements();
    },
    methods:{
        getAgreements: async function () {
            let request = await axios.get(route('api.agreements.index'));
            this.agreements = Agreement.createAgreementsFromArray(request.data);
        },
    }
}
</script>

