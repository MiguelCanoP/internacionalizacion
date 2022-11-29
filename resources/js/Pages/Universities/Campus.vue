<template>
    <AuthenticatedLayout>
        <Snackbar :timeout="snackbar.timeout" :text="snackbar.text" :type="snackbar.type"
                  :show="snackbar.status" @closeSnackbar="snackbar.status = false"></Snackbar>

        <v-container>
            <div class="d-flex flex-column align-end mb-8">
                <h2 class="align-self-start">Gestionar universidades</h2>
                <div>
                    <v-btn
                        color="primario"
                        class="grey--text text--lighten-4"
                        @click="createUniversityDialog = true"
                    >
                        Crear nueva universidad
                    </v-btn>
                </div>

            </div>

            <!--Inicia tabla-->
            <v-data-table
                loading-text="Cargando, por favor espere..."
                :loading="isLoading"
                :headers="headers"
                :items="universities"
                :items-per-page="5"
                class="elevation-1"
            >
                <template v-slot:item.actions="{ item }">

                    <v-icon
                        class="mr-2 primario--text"
                        @click="openEditUniversityModal(item)"
                    >
                        mdi-pencil
                    </v-icon>
                    <v-icon
                        class="primario--text"
                        @click="confirmDeleteUniversity(item)"
                    >
                        mdi-delete
                    </v-icon>
                </template>
            </v-data-table>
            <!--Acaba tabla-->

            <!------------Seccion de dialogos ---------->
            <!--Crear rol -->
            <v-dialog
                v-model="createUniversityDialog"
                persistent
                max-width="600px"
            >
                <v-card>
                    <v-card-title>
                        <span class="text-h5">Crear una nueva universidad</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col cols="12">
                                    <v-text-field
                                        label="Nombre de la universidad *"
                                        required
                                        v-model="university.name"
                                    ></v-text-field>
                                    <v-text-field
                                        label="Sitio web *"
                                        required
                                        v-model="university.website"
                                    ></v-text-field>
                                    <v-select
                                        color="primario"
                                        v-model="university.country"
                                        :items="countries"
                                        label="País"
                                        :item-value="(country)=>country"
                                        :item-text="(country)=>country.name">
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
                            @click="createUniversityDialog = false"
                        >
                            Cancelar
                        </v-btn>
                        <v-btn
                            color="primario"
                            text
                            @click="createUniversity"
                        >
                            Guardar cambios
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            <!--Confirmar borrar rol-->
            <confirm-dialog
                :show="deleteUniversityDialog"
                @canceled-dialog="deleteUniversityDialog = false"
                @confirmed-dialog="deleteUniversity(deletedUniversityId)"
            >
                <template v-slot:title>
                    Estas a punto de eliminar el rol seleccionado
                </template>

                ¡Cuidado! esta acción es irreversible

                <template v-slot:confirm-button-text>
                    Borrar
                </template>
            </confirm-dialog>

            <!--Editar university-->
            <v-dialog
                v-model="editUniversityDialog"
                persistent
                max-width="600px"
            >
                <v-card>
                    <v-card-title>
                        <span class="text-h5">Editar rol</span>
                    </v-card-title>
                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col cols="12">
                                    <v-text-field
                                        label="Nombre del rol *"
                                        required
                                        v-model="university.name"
                                    ></v-text-field>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                        label="ID del rol *"
                                        required
                                        v-model="university.customId"
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
                            @click="editUniversityDialog = false"
                        >
                            Cancelar
                        </v-btn>
                        <v-btn
                            color="primario"
                            text
                            @click="editUniversity"
                        >
                            Guardar cambios
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            <!------------Seccion de dialogos ---------->
        </v-container>

    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import {InertiaLink} from "@inertiajs/inertia-vue";
import {prepareErrorText, showSnackbar} from "@/HelperFunctions"
import ConfirmDialog from "@/Components/ConfirmDialog";
import University from "@/models/University";
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
                {text: 'Sitio web', value: 'website'},
                {text: 'País', value: 'country.name'},
                {text: 'Acciones', value: 'actions', sortable: false},
            ],
            countries: [],
            universities: [],
            //Universities models
            university: new University(),

            //Snackbars
            snackbar: {
                text: '...',
                status: false,
                timeout: 3000
            },
            //Dialogs
            createUniversityDialog: false,
            deleteUniversityDialog: false,
            editUniversityDialog: false,

            //Overlays
            isLoading: true,
        }
    },
    async created() {
        await this.getUniversities();
        this.getCountries();
        this.isLoading = false;
    },
    methods: {
        openEditUniversityModal: function (university) {
            this.university = {...university};
            this.editUniversityDialog = true;
        },
        editUniversity: async function () {
            //Verify request
            if (this.university.hasEmptyProperties()) {
                showSnackbar(this.snackbar, 'Por favor, completa todos los campos', 'error');
                return;
            }
            //Recollect information
            let data = this.university.toObjectRequest();

            try {
                let request = await axios.patch(route('api.universities.update', {'university': this.university.id}), data);
                this.editUniversityDialog = false;
                this.snackbar.text = request.data.message;
                this.snackbar.status = true;
                this.getUniversities();

                //Clear university information
                this.university = {
                    id: '',
                    name: '',
                    customId: '',
                };
            } catch (e) {
                this.snackbar.text = prepareErrorText(e);
                this.snackbar.status = true;
            }
        },

        confirmDeleteUniversity: function (university) {
            this.deletedUniversityId = university.id;
            this.deleteUniversityDialog = true;
        },

        deleteUniversity: async function (universityId) {
            try {
                let request = await axios.delete(route('api.universities.destroy', {university: universityId}));
                this.deleteUniversityDialog = false;
                showSnackbar(this.snackbar, request.data.message)
                await this.getUniversities();

            } catch (e) {
                this.snackbar.text = e.response.data.message;
                this.snackbar.status = true;
            }

        },
        getCountries: async function () {
            let request = await axios.get(route('api.countries.index'));
            this.countries = request.data;
        },
        getUniversities: async function () {
            let request = await axios.get(route('api.universities.index'));
            this.universities = request.data;
        },
        createUniversity: async function () {
            //Verify request
            console.log(this.university)
            if (this.university.hasEmptyProperties()) {
                showSnackbar(this.snackbar, 'Por favor, completa todos los campos', 'error');
                return;
            }
            //Recollect information
            let data = this.university.toObjectRequest();
            try {
                const url = route('api.universities.update', {'university': this.university.id ?? 0});
                let request = await axios.patch(url, data);
                showSnackbar(this.snackbar, request.data.message + 'vivaespaña');
                this.getUniversities();

                //Clear university information
                this.university = new University();
            } catch (e) {
                this.snackbar.text = prepareErrorText(e);
                this.snackbar.status = true;
            }

        }
    },


}
</script>
