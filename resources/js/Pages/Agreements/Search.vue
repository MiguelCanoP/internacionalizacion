<template>
    <v-app>
        <v-main>
            <v-container fluid>
                <v-data-iterator
                    :items="filteredItems"
                    :sort-desc="sortDesc"
                    sort-by="university.name"
                    :items-per-page="6"
                    :footer-props="{
                        'items-per-page-options': [6,9,15,-1]
                    }"
                >
                    <template v-slot:no-data>
                        <v-row>
                            <v-col cols="12" class="d-flex flex-column justify-center align-center">
                                <h1 class="text-center">
                                    Ningún convenio coincide con los criterios de búsqueda ingresados
                                </h1>
                                <v-img
                                    class="mt-5"
                                    width="250"
                                    height="250"
                                    src="images/no-results.png"/>

                            </v-col>
                        </v-row>
                    </template>
                    <template v-slot:header>
                        <v-toolbar
                            dark
                            color="#0f1f39"
                            class="mb-1"
                            height="auto"
                        >
                            <v-row class="py-3 ">
                                <v-col cols="12" sm="6" md="">
                                    <v-select
                                        v-model="program"
                                        flat
                                        solo-inverted
                                        hide-details
                                        :items="programs"
                                        :item-text="(pStatus)=> capitalize(pStatus.name)"
                                        item-value="id"
                                        prepend-inner-icon="mdi-book-open-blank-variant"
                                        label="Programas"
                                    ></v-select>
                                </v-col>

                                <v-col
                                    cols="12" sm="6" md="">
                                    <v-select
                                        v-model="country"
                                        flat
                                        solo-inverted
                                        hide-details
                                        :items="filteredCountries"
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
                                        :items="filteredUniversities"
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
                                        :item-text="(pStatus)=> capitalize(pStatus.name)"
                                        item-value="id"
                                        prepend-inner-icon="mdi-list-status"
                                        label="Estado"
                                    ></v-select>
                                </v-col>
                                <v-col cols="12" sm="6" md="">
                                    <v-btn
                                        block
                                        large
                                        depressed
                                        color="#0f1f39"
                                        @click="deleteFilters"
                                    >
                                        <v-icon>mdi-delete</v-icon>
                                        Borrar todos los filtros
                                    </v-btn>
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
                                        <span>
                                            {{ getCountryFlag(agreement.university.country.code) }}
                                        </span>
                                        <span
                                            class="text-h5 white--text ml-2">{{
                                                agreement.university.name
                                            }}</span>
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
            programs: [],
            program: '',
        }
    },
    async created() {
        this.getAgreements();
        this.getCountries();
        this.getUniversities();
        this.getAgreementTypes();
        this.getStatuses();
        this.getPrograms();
    },

    methods: {
        addAllElementSelectionItem(model, text) {
            model.unshift({id: '', name: text});
        },
        getAgreements: async function () {
            let request = await axios.get(route('api.agreements.index'));
            this.agreements = Agreement.createAgreementsFromArray(request.data);
            this.isLoading = false;
        },
        getCountryFlag: function (countryCode) {
            const codePoints = countryCode.toUpperCase().split("").map((char) => 127397 + char.charCodeAt(0));
            return String.fromCodePoint(...codePoints);
        },

        getCountries: async function () {
            let request = await axios.get(route('api.countries.index'));
            this.countries = request.data;
            this.addAllElementSelectionItem(this.countries, 'Todos los paises');
        },
        getUniversities: async function () {
            let request = await axios.get(route('api.universities.index'));
            this.universities = request.data;
            this.addAllElementSelectionItem(this.universities, 'Todas las universidades');
        },
        getAgreementTypes: async function () {
            let request = await axios.get(route('api.agreementTypes.index'));
            this.agreementTypes = request.data;
            this.addAllElementSelectionItem(this.agreementTypes, 'Todos los tipos de convenios');
        },
        getStatuses: async function () {
            let request = await axios.get(route('api.statuses.index'));
            this.statuses = request.data;
            this.addAllElementSelectionItem(this.statuses, 'Todos los estados');

        },
        getPrograms: async function () {
            let request = await axios.get(route('api.programs.index'));
            this.programs = request.data;
            this.addAllElementSelectionItem(this.programs, 'Todos los programas');
        },
        matchProperty: function (array, propertyPath, reference) {
            return array.filter((item) => {
                const propertyArr = propertyPath.split(".");
                const propertyValue = propertyArr.reduce((obj, key) => {
                    return obj && obj[key];
                }, item);
                return propertyValue === reference;
            });
        },
        deleteFilters() {
            this.program = '';
            this.country = '';
            this.university = '';
            this.agreementType = '';
            this.status = '';
        },
        capitalize: function (string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        },

        getFilteredAgreementsByCountry(agreements = null) {
            if (agreements === null) {
                agreements = this.agreements;
            }
            return this.matchProperty(agreements, 'university.country.id', this.country)
        },
        getFilteredAgreementsByUniversity(agreements = null) {
            if (agreements === null) {
                agreements = this.agreements;
            }
            return this.matchProperty(agreements, 'university.id', this.university);
        },

        getFilteredAgreementsByProgram(agreements = null) {
            if (agreements === null) {
                agreements = this.agreements;
            }
            return agreements.filter((agreement) => {
                let doesAgreementHaveProgram = false;
                agreement.programs.forEach((program) => {
                    if (program.id === this.program) {
                        doesAgreementHaveProgram = true;
                    }
                });
                return doesAgreementHaveProgram;
            })
        },
        getFilteredAgreementsByAgreementType(agreements = null) {
            if (agreements === null) {
                agreements = this.agreements;
            }
            return this.matchProperty(agreements, 'agreementType.id', this.agreementType)
        },

        getFilteredAgreementsByStatus(agreements = null) {
            if (agreements === null) {
                agreements = this.agreements;
            }
            return this.matchProperty(agreements, 'status', this.status)

        },


    },
    watch: {
        country(newCountry) {
            this.university = '';
        }
    },

    computed: {
        filteredItems() {
            let finalAgreements = this.agreements;

            if (this.program !== '') {
                finalAgreements = this.getFilteredAgreementsByProgram(finalAgreements);
            }
            if (this.country !== '') {
                finalAgreements = this.getFilteredAgreementsByCountry(finalAgreements);
            }
            if (this.university !== '') {
                finalAgreements = this.getFilteredAgreementsByUniversity(finalAgreements);
            }

            if (this.agreementType !== '') {
                finalAgreements = this.getFilteredAgreementsByAgreementType(finalAgreements);
            }
            if (this.status !== '') {
                finalAgreements = this.getFilteredAgreementsByStatus(finalAgreements);
            }
            return finalAgreements;
        },

        filteredCountries() {
            let finalCountries = this.countries;
            let finalAgreements = this.agreements;
            if (this.program !== '') {
                finalAgreements = this.getFilteredAgreementsByProgram();
                finalCountries = finalCountries.filter((country) => {
                    return finalAgreements.some((agreement) => agreement.university.country.id === country.id)
                });
            }
            this.addAllElementSelectionItem(finalCountries, 'Todos los paises');

            return finalCountries;
        },
        filteredUniversities() {
            let finalUniversities = this.universities;
            let finalAgreements = this.agreements;

            if (this.program !== '') {
                finalAgreements = this.getFilteredAgreementsByProgram(finalAgreements);
            }
            if (this.country !== '') {
                finalAgreements = this.getFilteredAgreementsByCountry(finalAgreements);
            }
            finalUniversities = finalUniversities.filter((university) => {
                return finalAgreements.some((agreement) => agreement.university.id === university.id)
            });
            this.addAllElementSelectionItem(finalUniversities, 'Todas las universidades');
            return finalUniversities;

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

