<script setup>
import { FilterMatchMode } from 'primevue/api';
import { ref, onMounted, onBeforeMount } from 'vue';
import { useToast } from 'primevue/usetoast';
import Message from 'primevue/message';
import InputMask from 'primevue/inputmask';
import InputGroup from 'primevue/inputgroup';
import InputGroupAddon from 'primevue/inputgroupaddon';

const toast = useToast();
const clients = ref(null);
const clientDialog = ref(false);
const showRest = ref(false);
// const provaDialog = ref(false);
const deleteClientDialog = ref(false);
const client = ref({ direccions: [] });
const filters = ref({});
const submitted = ref(false);
const clientToDelete = ref({});
const indexToDelete = ref(-1);
const idioma = ref([]);
const codiPostal = ref([]);
const dialogHeaderText = ref("");
const showAddButton = ref(true);
const showUpdateButton = ref(false);
const exists = ref(0);

const hideDialog = () => {
    clientDialog.value = false;
    submitted.value = false;

};

//funcio que al fer clic li passes un arrray buit i et crea un nou div
const addDireccio = () => {
    client.value.direccions.push({})
};

const openEdit = (clientToEdit) => {
    clientDialog.value = true
    //client.value = clientToEdit;

    client.value = JSON.parse(JSON.stringify({ ...clientToEdit }));
    dialogHeaderText.value = "Editar Client";
    showUpdateButton.value = true;
    showAddButton.value = false;
    exists.value = 0;
}
const confirmDeleteClient = () => {

    console.log(clientToDelete.value.id);
    axios.delete('/api/clients/' + clientToDelete.value.id)
        .then(response => {
            clients.value.splice(indexToDelete.value, 1)
            deleteClientDialog.value = false;
            toast.add({ severity: 'success', summary: 'Successful', detail: 'Client Esborrat', life: 3000 });
        })
}

const deleteClient = (client, index) => {
    deleteClientDialog.value = true
    indexToDelete.value = index;
    clientToDelete.value = client;
}

const openNew = () => {
    client.value = { direccions: [] };
    //submitted.value = false;
    clientDialog.value = true;
    dialogHeaderText.value = "Nou Client";
    showAddButton.value = true;
};

function showTheRest() {
    showRest.value = true;
}

function addClient() {
    // console.log('clic');
    axios.post('/api/clients', client.value)
        .then(response => {
            //afegim a la resposta l'ultim objecte afegit
            clients.value.push(response.data.data)
            console.log(response.data.data);
            clientDialog.value = false
            //client.value = response.data;
        })
        .catch(error => {
            console.log(error);
        })
}

function updateClient() {
    axios.put('/api/clients/' + client.value.id, client.value)
        .then(response => {

            replaceResult(client.value.id, response.data.data)
            clientDialog.value = false
        }).catch(error => {
            console.log(error);
        })
}
function getCodipostal(cp, direccio) {
    axios.get('/api/cp_municipis/' + cp)
        .then(response => {
            console.log(response);
            direccio.provincia_id = response.data.municipi.provincia.id;
            direccio.municipi_id = response.data.municipi.id;

            codiPostal.value = response.data;
            showTheRest();
        })
        .catch(error => {
            console.error('Error al obtener datos:', error);
        });
}

function getClient(nif) {
    axios.get('/api/clients/showByNif/' + nif)
        .then(response => {
            console.log(response.data);
            //client.value = response.data;
            exists.value = response.data;
        })
}

function replaceResult(id, newValue) {

    const index = clients.value.findIndex(client => client.id === id);
    if (index !== -1) {
        clients.value[index] = newValue;
        console.log(`Objecte amb ID ${id} reemplaçat amb èxit.`);
    } else {
        console.log(`No se encontró ningún objeto con ID ${id}. No se realizó ningún reemplazo.`);
    }
}
onMounted(() => {
    axios.get('/api/idiomes')
        .then(response => {
            console.log(response);
            idioma.value = response.data;
        })
        .catch(error => {
            console.error('Error al obtener datos:', error);
        });

});

onBeforeMount(() => {

    axios.get('/api/clients')
        .then(response => {
            console.log(response);
            clients.value = response.data;
        })
});
const initFilters = () => {
    filters.value = {
        global: { value: null, matchMode: FilterMatchMode.CONTAINS }
    };
};

initFilters();

const clearFilter = () => {
    initFilters();
};

// const exportCSV = () => {
//     dt.value.exportCSV();
// };



</script>



<template>
    <div class="grid">
        <div class="col-12">
            <div class="card">

                <!-- Toolbar amb botons NEW i EXPORT -->
                <Toolbar class="mb-4">
                    <template v-slot:start>
                        <div class="my-2">
                            <Button label="Nou Client" icon="pi pi-plus" class="mr-2" severity="success"
                                @click="openNew" />
                        </div>

                    </template>

                    <template v-slot:end>
                        <Button label="Exportar" icon="pi pi-upload" severity="help" @click="exportCSV($event)" />
                    </template>
                </Toolbar>

                <!-- PAGINADOR AL FINAL DEL LLISTAT DE CLIENTS -->
                <DataTable v-model:filters="filters" :value="clients" dataKey="id" :paginator="true" :rows="10"
                    :filters="filters"
                    paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                    :rowsPerPageOptions="[5, 10, 25]"
                    currentPageReportTemplate="Clients del {first} al {last} de {totalRecords} clients"
                    :globalFilterFields="['nif', 'name', 'surname1', 'telefon']">

                    <!-- HEADER -->
                    <template #header>
                        <div class="flex flex-column md:flex-row md:justify-content-between md:align-items-center">
                            <h5 class="m-0">Llistat Clients</h5>

                            <IconField iconPosition="left">
                                <InputIcon>
                                    <i class="pi pi-search" />
                                </InputIcon>
                                <InputText v-model="filters['global'].value" placeholder="Keyword Search" /> <Button
                                    type="button" icon="pi pi-filter-slash" label="Clear" outlined
                                    @click="clearFilter()" />
                            </IconField>
                        </div>
                    </template>

                    <!-- HEADER CAMPS QUE ES MOSTREN -->
                    <Column field="nif" header="Nif" :sortable="true" headerStyle="width:16%; min-width:10rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">Nif</span>
                            {{ slotProps.data.nif }}
                        </template>
                    </Column>
                    <Column field="name" header="Nom" :sortable="true" headerStyle="width:16%; min-width:10rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">Nom</span>
                            {{ slotProps.data.name }}
                        </template>
                    </Column>
                    <Column field="surname1" header="Cognom" :sortable="true" headerStyle="width:16%; min-width:8rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">Cognom</span>
                            {{ slotProps.data.surname1 }}
                        </template>
                    </Column>
                    <Column field="telefon" header="Telefon" :sortable="true" headerStyle="width:16%; min-width:10rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">Telèfon</span>
                            {{ slotProps.data.telefon }}
                        </template>
                    </Column>
                    <Column field="email" header="Email" :sortable="true" headerStyle="width:16%; min-width:10rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">Email</span>
                            {{ slotProps.data.email }}
                        </template>
                    </Column>
                    <Column field="idioma.idioma" header="Idioma" :sortable="true"
                        headerStyle="width:14%; min-width:10rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">Idioma</span>
                            <Tag severity="info">{{ slotProps.data.idioma?.idioma }}</Tag>
                        </template>
                    </Column>
                    <Column field="acciones" header="Acciones" :sortable="false" headerStyle="min-width:10rem;">
                        <template #body="slotProps">
                            <Button icon="pi pi-pencil" class="mr-2" severity="success" rounded
                                @click="openEdit(slotProps.data)" />
                            <Button icon="pi pi-trash" class="mt-2" severity="warning" rounded
                                @click="deleteClient(slotProps.data, slotProps.index)" />
                        </template>
                    </Column>
                </DataTable>




                <!-- DIALOG PER CREAR NOU CLIENT -->
                <Dialog v-model:visible="clientDialog" :style="{ width: '1200px' }" :header="dialogHeaderText"
                    :modal="true" class="p-fluid">
                    <Message severity="error" v-if="exists == 1" :closable="false">Ja hi ha un client amb aquest N.I.F
                    </Message>

                    <div class="card p-fluid">
                        <div class="p-fluid formgrid grid">

                            <div class="field col-12 md:col-6">
                                <label for="nif">Nif</label>
                                <InputGroup>
                                    <InputGroupAddon>
                                        <i class="pi pi-id-card"></i>
                                    </InputGroupAddon>
                                     <!-- @keydown.enter="getClient(client.nif)" v-on:blur="getClient(client.nif)"  -->
                                    <InputText id="nif" v-model.trim="client.nif" required="true" autofocus :invalid="submitted && !client.nif"/>
                                    <small class="p-invalid" v-if="submitted && !client.nif">El Nif es
                                        obligatori.</small>
                                </InputGroup>
                            </div>


                            <div class="field col-12 md:col-6">
                                <label for="name">Nom</label>
                                <InputGroup>
                                    <InputGroupAddon>
                                        <i class="pi pi-user"></i>
                                    </InputGroupAddon>
                                    <InputText id="name" v-model.trim="client.name" required="true" autofocus
                                        :invalid="submitted && !client.name" />
                                    <small class="p-invalid" v-if="submitted && !client.name">El nom es
                                        obligatori.</small>
                                </InputGroup>
                            </div>

                            <div class="field col-12 md:col-6">
                                <label for="cognom">Cognom</label>
                                <InputText v-model="client.surname1" id="cognom" type="text" />
                            </div>
                            <div class="field col-12 md:col-6">
                                <label for="cognom2">Segon Cognom</label>
                                <InputText v-model="client.surname2" id="cognom2" type="text" />
                            </div>
                            <div class="field col-12 md:col-6">
                                <label for="telefon">Telèfon</label>
                                <InputGroup>
                                    <InputGroupAddon>
                                        <i class="pi pi-phone"></i>
                                    </InputGroupAddon>
                                    <!--<InputText v-model="client.telefon" id="telefon" type="text" />-->
                                    <InputMask id="telefon" v-model="client.telefon" mask=" 999-999-999"
                                        placeholder="999-999-999" type="text" />
                                </InputGroup>
                            </div>
                            <div class="field col-12 md:col-6">
                                <label for="nif">Email</label>
                                <InputGroup>
                                    <InputGroupAddon>
                                        <i class="pi pi-envelope"></i>
                                    </InputGroupAddon>
                                    <InputText v-model="client.email" id="nif" type="text" />
                                </InputGroup>
                            </div>
                            <div class="field">
                                <label for="idioma" class="mb-3">Idioma</label>
                                <!-- optionValue= valor que guardo optionLabel=Valor que mostro -->
                                <Dropdown id="idioma" v-model="client.idioma_id" :options="idioma" optionValue="id"
                                    optionLabel="idioma" placeholder="Selecciona Idioma"></Dropdown>
                            </div>
                        </div>
                    </div>
                    <!-- BOTÓ AFEGIR DIRECCIO -->
                    <div class="my-2">
                        <div class="d-inline-block">
                            <Button label="Afegir direcció" icon="pi pi-plus" class="mr-2" severity="success"
                                @click="addDireccio()" />
                        </div>
                    </div>
                    <div v-for="direccio in client.direccions" class="card p-0 mb-2">
                        <div class="card-body">
                            <div class="p-fluid formgrid grid">
                                <div class="field col-6 ml-2 ">
                                    <p>Direcció</p>
                                </div>
                                <div class="field col-2">
                                    <p>Número</p>
                                </div>
                                <div class="field col-2">
                                    <p>Pis/Casa</p>
                                </div>
                                <div class="field col">
                                    <p>Porta</p>
                                </div>
                                <div class="field col-1">
                                </div>
                            </div>

                            <div class="list-group pl-3">
                                <div class="p-fluid formgrid grid">
                                    <div class="field col-6 p-1">
                                        <Textarea id="carrer" v-model="direccio.carrer" required placeholder="Direcció"
                                            autoResize rows="1" />
                                    </div>
                                    <div class="field col-2 p-1">
                                        <InputText id="numero" v-model="direccio.numero" required
                                            placeholder="Número" />
                                    </div>
                                    <div class="field col-2 p-1">
                                        <InputText id="pis" v-model="direccio.pis" required placeholder="Pis/casa" />
                                    </div>
                                    <div class="field col-2 p-1">
                                        <InputText id="porta" v-model="direccio.porta" required placeholder="Porta" />
                                    </div>
                                </div>


                                <div class="p-fluid formgrid grid">
                                    <div class="field col-2 p-1">
                                        <InputText id="cp" v-model="direccio.cp_id" placeholder="Codi Postal"
                                        v-on:blur="getCodipostal(direccio.cp_id, direccio)"   @keydown.enter="getCodipostal(direccio.cp_id, direccio) " />
                                    </div>
                                    <template v-if="showRest">
                                        <div class="field col-6 p-1">
                                            <Textarea id="municipi" v-model="codiPostal.municipi.name"
                                                placeholder="Municipi" autoResize rows="1" disabled />
                                        </div>

                                        <div class="field col-2 p-1">
                                            <InputText id="provincia" v-model="codiPostal.municipi.provincia.provincia"
                                                placeholder="Provincia" disabled />
                                        </div>
                                    </template>
                                </div>

                            </div>
                        </div>
                    </div>

                    <template #footer>
                        <Button label="Cancel.la" icon="pi pi-times" text="" @click="hideDialog" />
                        <Button v-if="showAddButton" @click="addClient" label="Guardar" icon="pi pi-check" text="" />
                        <Button v-if="showUpdateButton" @click="updateClient" label="Actualitzar" icon="pi pi-check"
                            text="" />
                    </template>
                </Dialog>


                <!-- DIALOG PER ESBORRAR  CLIENT -->
                <Dialog v-model:visible="deleteClientDialog" :style="{ width: '450px' }" header="Confirma" modal>
                    <div class="flex align-items-center justify-content-center">
                        <i class="pi pi-exclamation-triangle mr-3" style="font-size: 3rem" />
                        <span>
                            Esborrar Client <b>{{ clientToDelete.name }}</b>?
                        </span>
                    </div>
                    <template #footer>
                        <Button label="No" icon="pi pi-times" text @click="deleteClientDialog = false" />
                        <Button label="Yes" icon="pi pi-check" text @click="confirmDeleteClient" />
                    </template>
                </Dialog>



                <!-- <Dialog v-model:visible="deleteClientsDialog" :style="{ width: '450px' }" header="Confirma"
                    :modal="true">
                    <template #footer>
                        <Button label="No" icon="pi pi-times" text @click="deleteClientsDialog = false" />
                        <Button label="Yes" icon="pi pi-check" text @click="confirmDeleteClient" />
                    </template>
                </Dialog> -->
            </div>
        </div>
    </div>
</template>
