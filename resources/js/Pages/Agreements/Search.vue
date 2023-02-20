<template>
    <v-app>
        <v-main>
            <v-container fluid>
                <v-data-iterator
                    :items="filteredItems"
                    :sort-desc="sortDesc"
                    sort-by="university.name"
                    :items-per-page="6"
                    no-data-text="Cargando..."
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
                        >
                            <v-row>
                                <v-col>
                                    <v-select
                                        v-model="country"
                                        flat
                                        solo-inverted
                                        hide-details
                                        :items="countries"
                                        prepend-inner-icon="mdi-earth"
                                        label="Pais"
                                    ></v-select>

                                </v-col>
                                <v-col>
                                    <v-select
                                        v-model="university"
                                        flat
                                        solo-inverted
                                        hide-details
                                        :items="universities"
                                        prepend-inner-icon="mdi-school"
                                        label="Universidad"
                                    ></v-select>
                                </v-col>
                                <v-col>
                                    <v-select
                                        v-model="agreementType"
                                        flat
                                        solo-inverted
                                        hide-details
                                        :items="agreementTypes"
                                        prepend-inner-icon="mdi-handshake"
                                        label="Tipo de convenio"
                                    ></v-select>
                                </v-col>
                                <v-col>
                                    <v-select
                                        v-model="status"
                                        flat
                                        solo-inverted
                                        hide-details
                                        :items="statuses"
                                        prepend-inner-icon="mdi-list-status"
                                        label="Estado"
                                    ></v-select>
                                </v-col>

                                <template v-if="$vuetify.breakpoint.mdAndUp">
                                    <v-spacer></v-spacer>
                                    <v-col>
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
                                    </v-col>
                                </template>
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
                                    <v-window v-model="steps[agreement.id]">
                                        <v-window-item :value="1">
                                            <v-list>
                                                <AgreementCardItem
                                                    icon="mdi-handshake"
                                                    :title="agreement.agreementType.name"
                                                    subtitle="Tipo de convenio"
                                                />
                                                <v-divider inset></v-divider>

                                                <AgreementCardItem
                                                    icon="mdi-list-status"
                                                    :title="agreement.status"
                                                    subtitle="Estado del convenio"
                                                />
                                                <v-divider inset></v-divider>

                                                <AgreementCardItem
                                                    icon="mdi-earth"
                                                    :title="agreement.university.country.name"
                                                    subtitle="Pais"
                                                />
                                                <v-divider inset></v-divider>

                                                <AgreementCardItem
                                                    icon="mdi-link"
                                                    :title="agreement.university.website"
                                                    subtitle="Página web"
                                                />

                                                <v-divider inset></v-divider>

                                                <AgreementCardItem
                                                    icon="mdi-link"
                                                    :title="agreement.contactInfo"
                                                    subtitle="Información de contacto"
                                                />
                                                <v-divider inset></v-divider>
                                                <AgreementCardItem
                                                    icon="mdi-information"
                                                    :title="agreement.information"
                                                    subtitle="Información importante"
                                                />
                                            </v-list>

                                            <v-img
                                                src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/70/Harvard_University_logo.svg/799px-Harvard_University_logo.svg.png?20200802104842"
                                                height="150px"
                                                contain
                                            ></v-img>
                                        </v-window-item>

                                        <v-window-item :value="2">
                                            <v-list>
                                                <AgreementCardItem
                                                    icon="mdi-handshake"
                                                    :title="agreement.agreementType.name"
                                                    subtitle="Tipo de convenio"
                                                />
                                                <v-divider inset></v-divider>

                                                <AgreementCardItem
                                                    icon="mdi-list-status"
                                                    :title="agreement.status"
                                                    subtitle="Estado del convenio"
                                                />
                                                <v-divider inset></v-divider>

                                                <AgreementCardItem
                                                    icon="mdi-earth"
                                                    :title="agreement.university.country.name"
                                                    subtitle="Pais"
                                                />
                                                <v-divider inset></v-divider>
                                                <AgreementCardItem
                                                    icon="mdi-link"
                                                    :title="agreement.university.website"
                                                    subtitle="Página web"
                                                />
                                                <v-divider inset></v-divider>
                                            </v-list>

                                            <v-img
                                                src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/70/Harvard_University_logo.svg/799px-Harvard_University_logo.svg.png?20200802104842"
                                                height="150px"
                                                contain
                                            ></v-img>
                                        </v-window-item>

                                    </v-window>

                                    <v-card-actions class="mt-4">
                                        <v-btn
                                            :disabled="steps[agreement.id] === 1"
                                            text
                                            @click="decrement(agreement.id)"
                                        >
                                            Información general
                                        </v-btn>
                                        <v-spacer></v-spacer>
                                        <v-btn
                                            :disabled="steps[agreement.id] === 2"
                                            color="#0f1f39"
                                            class="white--text"
                                            depressed
                                            @click="incrementStep(agreement.id)"
                                        >
                                            Más información
                                        </v-btn>
                                    </v-card-actions>
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

export default {
    name: "Search",
    components: {
        GeneralLayout,
        Loading,
        AgreementCardItem
    },

    data() {
        return {
            //Window
            steps: [],
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
        this.setSteps();
    },

    methods: {
        getTitle(title) {
            return "<span>" + title + "</span>";
        },
        incrementStep(stepIndex) {
            const NewValue = this.steps[stepIndex] + 1;
            if (NewValue <= 2) {
                this.steps[stepIndex] = NewValue;
            }
        },
        decrement(stepIndex) {
            const NewValue = this.steps[stepIndex] - 1;
            if (NewValue <= 1) {
                this.steps[stepIndex] = NewValue;
            }
        },
        setSteps: function () {
            let steps = {};
            this.agreements.forEach((agreement) => {
                steps[agreement.id] = 1
            });
            this.steps = steps;
        },
        getAgreements: async function () {
            let request = await axios.get(route('api.agreements.index.public'));
            this.agreements = Agreement.createAgreementsFromArray(request.data);
            this.isLoading = false;
        },

    },
    computed: {
        filteredItems() {
            return this.agreements;
        },

    },
}
</script>

