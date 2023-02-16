<template>
    <AuthenticatedLayout>
        <Snackbar :timeout="snackbar.timeout" :text="snackbar.text" :type="snackbar.type"
                  :show="snackbar.status" @closeSnackbar="snackbar.status = false"></Snackbar>

        <v-container>
            <div class="d-flex flex-column align-end mb-8">
                <h2 class="align-self-start">Gestionar tipos de convenios</h2>
                <div class="mt-2">
                    <v-btn
                        color="primario"
                        class="grey--text text--lighten-4"
                        @click="openCreateAgreementTypeDialog"
                    >
                        Crear tipo de convenio
                    </v-btn>
                </div>

            </div>

            <!--Inicia tabla-->
            <v-data-table
                loading-text="Cargando, por favor espere..."
                :loading="isLoading"
                :headers="headers"
                :items="agreementTypes"
                :items-per-page="15"
                class="elevation-1"
            >
                <template v-slot:item.actions="{ item }">

                    <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">

                            <v-icon
                                v-bind="attrs"
                                v-on="on"
                                class="mr-2 primario--text"
                                @click="openEditAgreementTypeDialog(item)"
                            >
                                mdi-pencil
                            </v-icon>
                        </template>
                        <span>Editar tipo de convenio</span>
                    </v-tooltip>

                    <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                            <v-icon
                                v-bind="attrs"
                                v-on="on"
                                class="primario--text"
                                @click="confirmDeleteAgreementType(item)"
                            >
                                mdi-delete
                            </v-icon>
                        </template>
                        <span>Borrar tipo de convenio</span>
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
                                    <v-text-field
                                        label="Nombre del tipo de convenio *"
                                        required
                                        v-model="agreementType.name"
                                    ></v-text-field>
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
                            @click="patchAgreementType"
                        >
                            Guardar cambios
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            <!--Confirmar borrar rol-->
            <confirm-dialog
                :show="deleteAgreementTypeDialog"
                @canceled-dialog="deleteAgreementTypeDialog = false"
                @confirmed-dialog="deleteAgreementType(deletedAgreementTypeId)"
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
import {prepareErrorText, showSnackbar} from "@/HelperFunctions"
import ConfirmDialog from "@/Components/ConfirmDialog";
import AgreementType from "@/models/AgreementType";
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
                {text: 'Nombre', value: 'name'},
                {text: 'Acciones', value: 'actions', sortable: false},
            ],
            agreementType: new AgreementType(),
            agreementTypes: [],

            //Snackbars
            snackbar: {
                text: '...',
                status: false,
                timeout: 3000
            },
            //Dialogs
            dialogHeader: 'Crear nuevo tipo de convenio',
            deleteAgreementTypeDialog: false,
            deletedAgreementTypeId:0,
            dialog: false,

            //Overlays
            isLoading: true,
        }
    },
    async created() {
        await this.getAgreementTypes();
        this.isLoading = false;
    },
    methods: {
        openEditAgreementTypeDialog: function (agreementType) {
            this.agreementType = AgreementType.fromModel(agreementType);
            this.dialogHeader = `Editando ${agreementType.name}`;
            this.dialog = true;
        },
        openCreateAgreementTypeDialog: function () {
            this.agreementType =  new AgreementType(null,'','',this.agreementType.id)
            this.dialogHeader = `Crear nuevo tipo de convenio`;
            this.dialog = true;
        },

        confirmDeleteAgreementType: function (agreementType) {
            this.deletedAgreementTypeId = agreementType.id;
            this.deleteAgreementTypeDialog = true;
        },

        deleteAgreementType: async function (agreementTypeId) {
            try {
                let request = await axios.delete(route('api.agreementTypes.destroy', {agreementType: agreementTypeId}));
                this.deleteAgreementTypeDialog = false;
                showSnackbar(this.snackbar, request.data.message)
                await this.getAgreementTypes();

            } catch (e) {
                this.snackbar.text = e.response.data.message;
                this.snackbar.status = true;
            }

        },
        getAgreementTypes: async function () {
            let request = await axios.get(route('api.agreementTypes.index'));
            this.agreementTypes = request.data;
        },
        patchAgreementType: async function () {
            if (this.agreementType.hasEmptyProperties()) {
                showSnackbar(this.snackbar, 'Por favor, completa todos los campos', 'error');
                return;
            }
            //Recollect information
            let data = this.agreementType.toObjectRequest();

            try {
                const url = route('api.agreementTypes.update', {'agreementType': this.agreementType.id ?? 0});
                let request = await axios.patch(url, data);
                showSnackbar(this.snackbar, request.data.message);
                await this.getAgreementTypes();
                //Clear agreementType information
                this.agreementType =  new AgreementType()
                this.dialog = false;

            } catch (e) {
                this.snackbar.text = prepareErrorText(e);
                this.snackbar.status = true;
            }

        }
    },


}
</script>
