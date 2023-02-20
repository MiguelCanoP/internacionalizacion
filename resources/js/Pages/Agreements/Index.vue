<template>
    <AuthenticatedLayout>
        <Snackbar :timeout="snackbar.timeout" :text="snackbar.text" :type="snackbar.type"
                  :show="snackbar.status" @closeSnackbar="snackbar.status = false"></Snackbar>

        <v-container>
            <div class="d-flex flex-column align-end mb-8">
                <h2 class="align-self-start">Gestionar convenios</h2>
                <div>
                    <v-btn
                        color="primario"
                        class="grey--text text--lighten-4"
                        @click="openCreateAgreementDialog"
                    >
                        Crear nuevo convenio
                    </v-btn>
                </div>

            </div>

            <!--Inicia tabla-->
            <v-data-table
                loading-text="Cargando, por favor espere..."
                :loading="isLoading"
                :headers="headers"
                :items="agreements"
                :items-per-page="15"
                class="elevation-1"
            >
                <template v-slot:item.programs="{item}">
                    {{ getProgramsAsList(item.programs) }}
                </template>
                <template v-slot:item.actions="{ item }">
                    <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                            <v-icon
                                v-bind="attrs"
                                v-on="on"
                                class="mr-2 primario--text"
                                @click="openEditAgreementDialog(item)"
                            >
                                mdi-pencil
                            </v-icon>
                        </template>
                        <span>Editar convenio</span>
                    </v-tooltip>

                    <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                            <v-icon
                                v-bind="attrs"
                                v-on="on"
                                class="primario--text"
                                @click="confirmDeleteAgreement(item)"
                            >
                                mdi-delete
                            </v-icon>
                        </template>
                        <span>Borrar convenio</span>
                    </v-tooltip>

                </template>

            </v-data-table>
            <!--Acaba tabla-->

            <!------------Seccion de dialogos ---------->
            <!--Crear rol -->
            <v-dialog
                v-model="dialog"
                persistent
                max-width="600px"
            >
                <v-card>
                    <v-card-title>
                        <span class="text-h5">{{ dialogHeader }}</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col cols="12">
                                    <v-select
                                        color="primario"
                                        v-model="agreement.agreementType"
                                        :items="agreementTypes"
                                        label="Tipo de convenio"
                                        :item-value="(agreementType)=>agreementType"
                                        :item-text="(agreementType)=>agreementType.name">
                                    </v-select>
                                    <v-select
                                        color="primario"
                                        v-model="agreement.status"
                                        :items="statuses"
                                        label="Estado"
                                        :item-value="(status)=>status.value"
                                        :item-text="(status)=>status.placeholder">
                                    </v-select>

                                    <v-textarea
                                        outlined
                                        no-resize
                                        counter
                                        rows="3"
                                        label="Información de la oferta"
                                        required
                                        v-model="agreement.information"
                                    ></v-textarea>
                                    <v-textarea
                                        no-resize
                                        outlined
                                        counter
                                        rows="3"
                                        label="Información de contacto"
                                        required
                                        v-model="agreement.contactInfo"
                                    ></v-textarea>
                                    <v-select
                                        color="primario"
                                        v-model="agreement.university"
                                        :items="universities"
                                        label="Universidad"
                                        :item-value="(university)=>university.id"
                                        :item-text="(university)=>university.name">
                                    </v-select>
                                    <v-select
                                        multiple
                                        color="primario"
                                        v-model="agreement.programs"
                                        :items="programs"
                                        label="Programas"
                                        :item-value="(program)=>program"
                                        :item-text="(program)=>program.name">
                                    </v-select>
                                </v-col>
                            </v-row>
                        </v-container>
                        <small>Los campos con * son obligatorios</small>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="primario"
                            text
                            @click="dialog = false"
                        >
                            Cancelar
                        </v-btn>
                        <v-btn
                            color="primario"
                            text
                            @click="patchAgreement"
                        >
                            Guardar cambios
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            <!--Confirmar borrar rol-->
            <confirm-dialog
                :show="deleteAgreementDialog"
                @canceled-dialog="deleteAgreementDialog = false"
                @confirmed-dialog="deleteAgreement(deletedAgreementId)"
            >
                <template v-slot:title>
                    Estas a punto de eliminar el rol seleccionado
                </template>

                ¡Cuidado! esta acción es irreversible

                <template v-slot:confirm-button-text>
                    Borrar
                </template>
            </confirm-dialog>

            <!------------Seccion de dialogos ---------->
        </v-container>

    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import {InertiaLink} from "@inertiajs/inertia-vue";
import {prepareErrorText, showSnackbar, getCommaSeparatedArray} from "@/HelperFunctions"
import ConfirmDialog from "@/Components/ConfirmDialog";
import Agreement from "@/models/Agreement";
import Snackbar from "@/Components/Snackbar";

export default {
    components: {
        ConfirmDialog,
        AuthenticatedLayout,
        InertiaLink,
        Snackbar,
    },
    data: () => {
        return {
            //Table info
            headers: [
                {text: 'ID', value: 'id'},
                {text: 'Universidad', value: 'university.name'},
                {text: 'Tipo de convenio', value: 'agreementType.name'},
                {text: 'Estado', value: 'status'},
                {text: 'Información', value: 'information'},
                {text: 'Contacto', value: 'contactInfo'},
                {text: 'Programas', value: 'programs'},
                {text: 'Acciones', value: 'actions', sortable: false},
            ],
            agreementTypes: [],
            universities: [],
            programs: [],


            //Agreements models
            agreement: new Agreement(),
            agreements: [],
            //Static functions getters
            statuses: [],

            //Snackbars
            snackbar: {
                text: '...',
                status: false,
                timeout: 3000
            },
            //Dialogs
            dialogHeader: 'Crear un nuevo convenio',
            deleteAgreementDialog: false,
            deletedAgreementId: 0,
            dialog: false,

            //Overlays
            isLoading: true,
        }
    },
    async created() {
        await this.getAgreements();
        this.getAgreementTypes();
        this.getUniversities();
        this.getPrograms();
        this.initModelStaticFunction();
        this.isLoading = false;
    },
    methods: {
        getProgramsAsList: function (programs) {
            const programNames = programs.map(function (program) {
                return program.name
            });
            return getCommaSeparatedArray(programNames)
        },
        initModelStaticFunction: function () {
            this.statuses = Agreement.getPossibleStatuses();
        },
        openEditAgreementDialog: function (agreement) {
            console.log(agreement);
            this.agreement = Agreement.fromModel(agreement);
            this.dialogHeader = `Editando convenio con id ${agreement.id}`;
            this.dialog = true;
        },
        openCreateAgreementDialog: function () {
            this.agreement = new Agreement();
            this.dialogHeader = `Crear nuevo convenio`;
            this.dialog = true;
        },

        confirmDeleteAgreement: function (agreement) {
            console.log(agreement);
            this.deletedAgreementId = agreement.id;
            this.deleteAgreementDialog = true;
        },

        deleteAgreement: async function (agreementId) {
            console.log(agreementId);
            console.log(route('api.agreements.destroy', {agreement: agreementId}));

            try {
                let request = await axios.delete(route('api.agreements.destroy', {agreement: agreementId}));
                this.deleteAgreementDialog = false;
                showSnackbar(this.snackbar, request.data.message)
                await this.getAgreements();

            } catch (e) {
                this.snackbar.text = e.response.data.message;
                this.snackbar.status = true;
            }

        },
        getPrograms: async function () {
            let request = await axios.get(route('api.programs.index'));
            this.programs = request.data;
        },
        getUniversities: async function () {
            let request = await axios.get(route('api.universities.index'));
            let universities = request.data;
            universities.forEach((university) => {
                delete university.country;
            });
            this.universities = request.data;
            console.log(universities)
        },
        getAgreementTypes: async function () {
            let request = await axios.get(route('api.agreementTypes.index'));
            this.agreementTypes = request.data;
        },

        getAgreements: async function () {
            let request = await axios.get(route('api.agreements.index'));
            this.agreements = Agreement.createAgreementsFromArray(request.data);
        },
        patchAgreement: async function () {
            if (this.agreement.hasEmptyProperties()) {
                showSnackbar(this.snackbar, 'Por favor, completa todos los campos', 'error');
                return;
            }
            //Recollect information
            let data = this.agreement.toObjectRequest();
            try {
                const url = route('api.agreements.update', {'agreement': this.agreement.id ?? 0});
                let request = await axios.patch(url, data);
                showSnackbar(this.snackbar, request.data.message);
                await this.getAgreements();
                //Clear agreement information
                this.agreement = new Agreement();
                this.dialog = false;

            } catch (e) {
                this.snackbar.text = prepareErrorText(e);
                this.snackbar.status = true;
            }

        }
    },


}
</script>
