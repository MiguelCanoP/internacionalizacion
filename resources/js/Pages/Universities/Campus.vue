<template>
    <AuthenticatedLayout>
        <Snackbar :timeout="snackbar.timeout" :text="snackbar.text" :type="snackbar.type"
                  :show="snackbar.status" @closeSnackbar="snackbar.status = false"></Snackbar>

        <v-container>
            <div class="d-flex flex-column align-end mb-8">
                <h2 class="align-self-start">Gestionar campus de la Universidad {{ university.name }}</h2>
                <div class="mt-2">
                    <v-btn
                        color="primario"
                        class="grey--text text--lighten-4"
                        @click="openCreateCampusDialog"
                    >
                        Crear campus
                    </v-btn>
                </div>

            </div>

            <!--Inicia tabla-->
            <v-data-table
                loading-text="Cargando, por favor espere..."
                :loading="isLoading"
                :headers="headers"
                :items="campuses"
                :items-per-page="5"
                class="elevation-1"
            >
                <template v-slot:item.actions="{ item }">

                    <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">

                            <v-icon
                                v-bind="attrs"
                                v-on="on"
                                class="mr-2 primario--text"
                                @click="openEditCampusDialog(item)"
                            >
                                mdi-pencil
                            </v-icon>
                        </template>
                        <span>Editar campus</span>
                    </v-tooltip>

                    <v-tooltip bottom>
                        <template v-slot:activator="{ on, attrs }">
                            <v-icon
                                v-bind="attrs"
                                v-on="on"
                                class="primario--text"
                                @click="confirmDeleteCampus(item)"
                            >
                                mdi-delete
                            </v-icon>
                        </template>
                        <span>Borrar universidad</span>
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
                                        label="Nombre del campus *"
                                        required
                                        v-model="campus.name"
                                    ></v-text-field>
                                    <v-text-field
                                        label="Ciudad *"
                                        required
                                        v-model="campus.city"
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
                            @click="patchCampus"
                        >
                            Guardar cambios
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            <!--Confirmar borrar rol-->
            <confirm-dialog
                :show="deleteCampusDialog"
                @canceled-dialog="deleteCampusDialog = false"
                @confirmed-dialog="deleteCampus(deletedCampusId)"
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
import Campus from "@/models/Campus";
import Snackbar from "@/Components/Snackbar";

export default {
    components: {
        ConfirmDialog,
        AuthenticatedLayout,
        InertiaLink,
        Snackbar,
    },
    props: {
        university: Object
    },
    data: () => {
        return {
            //Table info
            headers: [
                {text: 'Nombre', value: 'name'},
                {text: 'Ciudad', value: 'city'},
                {text: 'Acciones', value: 'actions', sortable: false},
            ],
            campus: new Campus(),
            campuses: [],

            //Snackbars
            snackbar: {
                text: '...',
                status: false,
                timeout: 3000
            },
            //Dialogs
            dialogHeader: 'Crear nuevo campus',
            deleteCampusDialog: false,
            deletedCampusId:0,
            dialog: false,

            //Overlays
            isLoading: true,
        }
    },
    async created() {
        await this.getCampuses();
        this.isLoading = false;
    },
    methods: {
        openEditCampusDialog: function (campus) {
            this.campus = Campus.fromModel(campus);
            this.dialogHeader = `Editando ${campus.name}`;
            this.dialog = true;
        },
        openCreateCampusDialog: function () {
            this.campus =  new Campus(null,'','',this.university.id)
            this.dialogHeader = `Crear nuevo campus`;
            this.dialog = true;
        },

        confirmDeleteCampus: function (campus) {
            this.deletedCampusId = campus.id;
            this.deleteCampusDialog = true;
        },

        deleteCampus: async function (campusId) {
            try {
                let request = await axios.delete(route('api.campuses.destroy', {campus: campusId}));
                this.deleteCampusDialog = false;
                showSnackbar(this.snackbar, request.data.message)
                await this.getCampuses();

            } catch (e) {
                this.snackbar.text = e.response.data.message;
                this.snackbar.status = true;
            }

        },
        getCampuses: async function () {
            let request = await axios.get(route('api.universities.campuses', {university: this.university.id}));
            this.campuses = request.data;
        },
        patchCampus: async function () {
            if (this.campus.hasEmptyProperties()) {
                showSnackbar(this.snackbar, 'Por favor, completa todos los campos', 'error');
                return;
            }
            //Recollect information
            let data = this.campus.toObjectRequest();

            try {
                const url = route('api.campuses.update', {'campus': this.campus.id ?? 0});
                let request = await axios.patch(url, data);
                showSnackbar(this.snackbar, request.data.message);
                await this.getCampuses();
                //Clear campus information
                this.campus =  new Campus(null,'','',this.university.id)
                this.dialog = false;

            } catch (e) {
                this.snackbar.text = prepareErrorText(e);
                this.snackbar.status = true;
            }

        }
    },


}
</script>
