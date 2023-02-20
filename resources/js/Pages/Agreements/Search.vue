<template>
    <v-app>
        <v-main>
            <v-container fluid>
                <v-data-iterator
                    :items="filteredItems"
                    :sort-desc="sortDesc"
                    sort-by="university.name"
                    :items-per-page="6"
                    no-data-text="Ningún convenio coincide con los criterios de búsqueda ingresados"
                    no-results-text="No se encontró ningún resultado que cumpla tu criterio de búsqueda"
                    :footer-props="{
                        'items-per-page-options': [6,9,15,-1]
                    }"
                >
                    <template v-slot:header>
                        <v-toolbar
                            dark
                            color="#0f1f39"
                            class="mb-1"
                            height="auto"
                        >
                            <v-row class="py-3 ">
                                <v-col
                                    cols="12" sm="6" md="">
                                    <v-select
                                        v-model="country"
                                        flat
                                        solo-inverted
                                        hide-details
                                        :items="countries"
                                        item-text="name"
                                        item-value="id"
                                        prepend-inner-icon="mdi-earth"
                                        label="Pais"
                                    ></v-select>

                                </v-col>
                                <v-col cols="12" sm="6" md="">
                                    <v-select
                                        v-model="university"
                                        flat
                                        solo-inverted
                                        hide-details
                                        :items="universities"
                                        item-text="name"
                                        item-value="id"
                                        prepend-inner-icon="mdi-school"
                                        label="Universidad"
                                    ></v-select>
                                </v-col>
                                <v-col cols="12" sm="6" md="">
                                    <v-select
                                        v-model="agreementType"
                                        flat
                                        solo-inverted
                                        hide-details
                                        :items="agreementTypes"
                                        item-text="name"
                                        item-value="id"
                                        prepend-inner-icon="mdi-handshake"
                                        label="Tipo de convenio"
                                    ></v-select>
                                </v-col>
                                <v-col cols="12" sm="6" md="">
                                    <v-select
                                        v-model="status"
                                        flat
                                        solo-inverted
                                        hide-details
                                        :items="statuses"
                                        item-text="name"
                                        item-value="id"
                                        prepend-inner-icon="mdi-list-status"
                                        label="Estado"
                                    ></v-select>
                                </v-col>
                                <v-spacer></v-spacer>
                                <v-col cols="12" md="">
                                    <div class="d-flex justify-center">

                                        <v-btn-toggle
                                            v-model="sortDesc"
                                            mandatory
                                        >
                                            <v-btn
                                                large
                                                depressed
                                                color="#0f1f39"
                                                :value="false"
                                            >
                                                <v-icon>mdi-arrow-up</v-icon>
                                            </v-btn>
                                            <v-btn
                                                large
                                                depressed
                                                color="#0f1f39"
                                                :value="true"
                                            >
                                                <v-icon>mdi-arrow-down</v-icon>
                                            </v-btn>
                                        </v-btn-toggle>
                                    </div>
                                </v-col>
                            </v-row>
                        </v-toolbar>
                    </template>

                    <template v-slot:default="props">
                        <Loading v-if="isLoading"/>
                        <v-row class="mt-3" v-else
                               align="start"
                        >
                            <v-col
                                v-for="(agreement,index) in props.items"
                                :key="agreement.id"
                                cols="12"
                                md="4"
                            >
                                <v-card>
                                    <v-card-title style="background-color:#0f1f39">
                                        <span class="text-h5 white--text">{{ agreement.university.name }}</span>
                                    </v-card-title>
                                    <v-list>
                                        <AgreementCardItem
                                            icon="mdi-handshake-outline"
                                            :title="agreement.agreementType.name"
                                            subtitle="Tipo de convenio"
                                        />
                                        <v-divider inset></v-divider>

                                        <AgreementCardItem
                                            icon="mdi-list-status"
                                            :title="agreement.status"
                                            uppercase
                                            subtitle="Estado del convenio"
                                        />
                                        <v-divider inset></v-divider>

                                        <AgreementCardItem
                                            icon="mdi-earth"
                                            :title="agreement.university.country.name"
                                            subtitle="Pais"
                                        />
                                        <v-divider inset></v-divider>
                                        <a :href="agreement.university.website" target="_blank">
                                            <AgreementCardItem
                                                icon="mdi-link"
                                                :title="agreement.university.website"
                                                subtitle="Página web"
                                            />
                                        </a>


                                        <v-divider inset></v-divider>

                                        <AgreementCardItem
                                            icon="mdi-email-outline"
                                            :title="agreement.contactInfo"
                                            subtitle="Información de contacto"
                                        />
                                        <v-divider inset></v-divider>

                                        <AgreementCardCollapsableItem
                                            icon="mdi-information"
                                            :title="agreement.information "
                                            subtitle="Información importante"
                                        />

                                        <v-divider inset></v-divider>

                                        <v-list-group
                                        >
                                            <template v-slot:prependIcon>
                                                <v-icon color="#0f1f39">mdi-school</v-icon>
                                            </template>

                                            <template v-slot:activator>
                                                <v-list-item-content>
                                                    <v-list-item-title class="text-wrap text-justify custom-title">
                                                        Haz clic acá para conocer la lista completa de programas
                                                    </v-list-item-title>
                                                    <v-list-item-subtitle>
                                                        Programas para los que aplica el convenio
                                                    </v-list-item-subtitle>
                                                </v-list-item-content>
                                            </template>
                                            <v-list>
                                                <v-list-item
                                                    v-for="program in agreement.programs"
                                                    :key="program.id"
                                                >
                                                    <v-list-item-icon>
                                                        <v-icon color="#0f1f39">
                                                            mdi-check-circle
                                                        </v-icon>
                                                    </v-list-item-icon>
                                                    <v-list-item-content>
                                                        <v-list-item-title class="text-wrap text-justify custom-title">
                                                            {{ program.name }}
                                                        </v-list-item-title>
                                                        <v-list-item-subtitle>
                                                            {{ program.faculty.name }}
                                                        </v-list-item-subtitle>
                                                    </v-list-item-content>
                                                </v-list-item>
                                            </v-list>
                                        </v-list-group>
                                    </v-list>
                                </v-card>
                            </v-col>
                        </v-row>
                    </template>
                </v-data-iterator>
            </v-container>
        </v-main>
    </v-app>


</template>

<script>
import Agreement from "@/models/Agreement";
import GeneralLayout from "@/Layouts/GeneralLayout";
import Loading from "@/Pages/Agreements/Components/Loading";
import AgreementCardItem from "@/Pages/Agreements/Components/AgreementCardItem";
import AgreementCardCollapsableItem from "@/Pages/Agreements/Components/AgreementCardCollapsableItem";

export default {
    name: "Search",
    components: {
        GeneralLayout,
        Loading,
        AgreementCardItem,
        AgreementCardCollapsableItem
    },

    data() {
        return {

            //For table
            sortDesc: false,
            agreements: [],
            isLoading: true,

            //For filters
            countries: [],
            country: '',
            universities: [],
            university: '',
            agreementTypes: [],
            agreementType: '',
            statuses: [],
            status: '',
        }
    },
    async created() {
        await this.getAgreements();
        await this.getcountries();
        await this.getUniversities();
        await this.getagreementTypes();
        await this.getstatuses()
    },

    methods: {
        getAgreements: async function () {
            let request = await axios.get(route('api.agreements.index'));
            this.agreements = Agreement.createAgreementsFromArray(request.data);
            this.isLoading = false;
        },
    //     countries , universities , agreementTypes ,status

        getcountries:async function(){
            let request= await axios.get(route('api.countries.index'));
            this.countries= request.data;
            this.isLoading=false;
        },
        getUniversities:async function(){
            let request=await axios.get(route('api.universities.index'));
            this.universities=request.data;
            this.isLoading=false;
        },
        getagreementTypes:async function(){
            let request=await axios.get (route('api.agreementTypes.index'));
            this.agreementTypes=request.data;
            this.isLoading=false;
        },
        getstatuses:async function (){
            let request= await axios.get(route('api.statuses.index'));
            this.statuses=request.data;
            this.isLoading= false;
        }


    },
    computed: {
        filteredItems() {
            return this.agreements;
        },

    },
}
</script>

<style scoped>
a:link {
    text-decoration: none;
}

a:visited {
    text-decoration: none;
}

a:hover {
    text-decoration: none;
}

a:active {
    text-decoration: none;
}
</style>

