<script setup>
import { FilterMatchMode, FilterOperator } from 'primevue/api';
import { ref, onMounted, onBeforeMount } from 'vue';
import { useToast } from 'primevue/usetoast';
import Message from 'primevue/message';
import InputMask from 'primevue/inputmask';
import InputGroup from 'primevue/inputgroup';
import InputGroupAddon from 'primevue/inputgroupaddon';

//const selectedProducts = ref(null);
//const  proveidorDeleteAlert = ref(false);
//const dt = ref(null);
//const dropdownItem = ref(null);

const toast = useToast();
const proveidors = ref(null);
const proveidorDialog = ref(false);
const deleteProveidorDialog = ref(false);
const showRest = ref(false);
// const provaDialog = ref(false);
const proveidor = ref({ direccions_proveidors: [] });
const filters = ref({});
const submitted = ref(false);
const proveidorToDelete = ref({});
const indexToDelete = ref(-1);
const codiPostal = ref([]);
const dialogHeaderText = ref("");
const showAddButton = ref(true);
const showUpdateButton = ref(false);
const exists = ref(0);


const hideDialog = () => {
    proveidorDialog.value = false;
    submitted.value = false;
};
// const punt_iso = ref([{
//     name: "test", code: 1
// }]);


//funcio que al fer clic li passes un arrray buit i et crea un nou div
const addDireccio = () => {
    proveidor.value.direccions_proveidors.push({})
};

const openEdit = (proveidorToEdit) => {
    proveidorDialog.value = true

    proveidor.value = JSON.parse(JSON.stringify({ ...proveidorToEdit }));
    dialogHeaderText.value = "Editar Proveidor";
    showUpdateButton.value = true;
    showAddButton.value = false;
    exists.value = 0;

}

const confirmDeleteProveidor = () => {

    console.log(proveidorToDelete.value.id);
    axios.delete('/api/proveidors/' + proveidorToDelete.value.id)
        .then(response => {
            proveidors.value.splice(indexToDelete.value, 1)
            deleteProveidorDialog.value = false;
            toast.add({ severity: 'sucess', summary: 'Successful', detail: 'proveidor Esborrat', life: 3000 });
        })
}

const deleteProveidor = (proveidor, index) => {
    deleteProveidorDialog.value = true
    indexToDelete.value = index;
    proveidorToDelete.value = proveidor;
}


const openNew = () => {
    proveidor.value = { direccions_proveidors: [] };
    //submitted.value = false;
    proveidorDialog.value = true;
    dialogHeaderText.value = "Nou Proveidor";

};

function showTheRest() {
    showRest.value = true;
}

function addProveidor() {

    axios.post('/api/proveidors', proveidor.value)
        .then(response => {
            //console.log(response);
            proveidors.value.push(response.data.data)
            console.log(response.data.data);
            proveidorDialog.value = false
            //proveidor.value = response.data;
        })
        .catch(error => {
            console.log(error);
        })
}

function updateProveidor() {
    axios.put('/api/proveidors/' + proveidor.value.id, proveidor.value)
        .then(response => {

            replaceResult(proveidor.value.id, response.data.data)
            proveidorDialog.value = false
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

 function getProveidor(nif) {
     axios.get('/api/proveidors/showByNif/' + nif)
         .then(response => {
             console.log(response.data);

             exists.value=response.data;
         })
 }

function replaceResult(id, newValue) {

    const index = proveidors.value.findIndex(proveidor => proveidor.id === id);
    if (index !== -1) {
        proveidors.value[index] = newValue;
        console.log(`Objeto con ID ${id} reemplazado con éxito.`);
    } else {
        console.log(`No se encontró ningún objeto con ID ${id}. No se realizó ningún reemplazo.`);
    }
}
onBeforeMount(() => {
    axios.get('/api/proveidors')
        .then(response => {
            console.log(response);
            proveidors.value = response.data;
        })
        .catch(error => {
            console.error('Error al obtener datos:', error);
        });
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



</script>

<template>
    <div class="grid">
        <div class="col-12">
            <div class="card">

                <!--Toolbar amb botons NEW DELETE IMPORT EXPORT-->
                <Toolbar class="mb-4">
                    <template v-slot:start>
                        <div class="my-2">
                            <Button label="Nou Proveidor" icon="pi pi-plus" class="mr-2" severity="success"
                                @click="openNew" />
                        </div>
                    </template>

                    <template v-slot:end>
                        <Button label="Exportar" icon="pi pi-upload" severity="help" @click="exportCSV($event)" />
                    </template>

                </Toolbar>

                <!-- PAGINADOR AL FINAL DEL LLISTAT DE PROVEIDORS -->
                <DataTable v-model:filters="filters" :value="proveidors" :rows="10" dataKey="id" :paginator="true"
                    paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                    :rowsPerPageOptions="[5, 10, 25]"
                    currentPageReportTemplate="Proveidors del {first} al {last} de {totalRecords} proveidors"
                    :globalFilterFields="['nif', 'name', 'telefon', 'email']">

                    <!-- HEADER -->
                    <template #header>
                        <div class="flex flex-column md:flex-row md:justify-content-between md:align-items-center">
                            <h5 class="m-0">Llistat Proveidors</h5>
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
                    <Column field="nif" header="Nif" :sortable="true" headerStyle="width:26%; min-width:10rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">Nif</span>
                            {{ slotProps.data.nif }}
                        </template>
                    </Column>
                    <Column field="name" header="Nom" :sortable="true" headerStyle="width:26%; min-width:10rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">Nom</span>
                            {{ slotProps.data.name }}
                        </template>
                    </Column>
                    <Column field="telefon" header="Telefon" :sortable="true" headerStyle="width:26%; min-width:10rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">Telèfon</span>
                            {{ slotProps.data.telefon }}
                        </template>
                    </Column>
                    <Column field="email" header="Email" :sortable="true" headerStyle="width:26%; min-width:10rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">Email</span>
                            {{ slotProps.data.email }}
                        </template>
                    </Column>
                    <Column field="acciones" header="Acciones" :sortable="false" headerStyle="min-width:10rem;">
                        <template #body="slotProps">
                            <Button icon="pi pi-pencil" class="mr-2" severity="success" rounded
                                @click="openEdit(slotProps.data)" />
                            <Button icon="pi pi-trash" class="mt-2" severity="warning" rounded
                                @click="deleteProveidor(slotProps.data, slotProps.index)" />
                        </template>
                    </Column>
                </DataTable>




                <!-- DIALOG PER CREAR NOU PROVEIDOR -->
                <Dialog v-model:visible="proveidorDialog" :style="{ width: '1200px' }" :header="dialogHeaderText"
                    :modal="true" class="p-fluid">
                    <Message severity="error" v-if="exists == 1" :closable="false">Ja hi ha un proveidor amb aquest N.I.F
                    </Message>
                    <!-- <img :src="'/demo/images/product/' + product.image" :alt="product.image" v-if="product.image" width="150" class="mt-0 mx-auto mb-5 block shadow-2" /> -->

                    <div class="card p-fluid">
                        <div class="p-fluid formgrid grid">

                            <div class="field col-12 md:col-6">
                                <label for="nif">Nif</label>
                                <InputGroup>
                                    <InputGroupAddon>
                                        <i class="pi pi-id-card"></i>
                                    </InputGroupAddon>
                                    <InputText v-model.trim="proveidor.nif" required="true" type="text" autofocus
                                    :invalid="submitted && !proveidor.nif" @keydown.enter="getProveidor(proveidor.nif)"
                                    v-on:blur="getProveidor(proveidor.nif)" />
                                </InputGroup>
                            </div>

                            <div class="field col-12 md:col-6">
                                <label for="name">Nom</label>
                                <InputGroup>
                                    <InputGroupAddon>
                                        <i class="pi pi-user"></i>
                                    </InputGroupAddon>
                                    <InputText id="name" v-model.trim="proveidor.name" required="true" autofocus
                                        :invalid="submitted && !proveidor.name" />
                                    <small class="p-invalid" v-if="submitted && !proveidor.name">El nom es
                                        obligatori.</small>
                                </InputGroup>
                            </div>

                            <div class="field col-12 md:col-6">
                                <label for="telefon">Telèfon</label>
                                <InputGroup>
                                    <InputGroupAddon>
                                        <i class="pi pi-phone"></i>
                                    </InputGroupAddon>
                                    <!--<InputText v-model="proveidor.telefon" id="telefon" type="text" />-->
                                    <InputMask id="telefon" v-model="proveidor.telefon" mask=" 999-999-999"
                                        placeholder="999-999-999" type="text" />
                                </InputGroup>
                            </div>
                            <div class="field col-12 md:col-6">
                                <label for="email">Email</label>
                                <InputGroup>
                                    <InputGroupAddon>
                                        <i class="pi pi-envelope"></i>
                                    </InputGroupAddon>
                                    <InputText v-model="proveidor.email" id="email" type="text" />
                                </InputGroup>
                            </div>
                            <div class="field col-12 md:col-6">
                                <label for="telefon2">Telefon2</label>
                                <InputGroup>
                                    <InputGroupAddon>
                                        <i class="pi pi-phone"></i>
                                    </InputGroupAddon>
                                    <!--<InputText v-model="proveidor.telefon2"id="telefon2" type="text" />-->
                                    <InputMask id="telefon2" v-model="proveidor.telefon2" mask=" 999-999-999"
                                        placeholder="999-999-999" type="text" />
                                </InputGroup>
                            </div>
                            <div class="field col-12 md:col-6">
                                <label for="contacte">contacte</label>
                                <InputText v-model="proveidor.contacte" id="contacte" type="text" />
                            </div>
                            <div class="field col-12 md:col-6">
                                <label for="diacobrament">diaCobrament</label>
                                <InputNumber v-model="proveidor.diacobrament" inputId="diacobrament" mode="decimal" showButtons
                                :min="1" :max="31"/>
                            </div>
                            <div class="field col-12 md:col-6">
                                <label for="encurs">enCurs</label>
                                <Checkbox v-model="proveidor.encurs" :binary="true" />
                                <!-- <InputText v-model="proveidor.encurs" id="encurs" type="text" />  -->
                            </div>
                            <div class="field col-12 ">
                                <label for="observacions">Observacions</label>
                                <Textarea v-model="proveidor.observacions" id="obsevacions" type="text" auto />
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
                    <div v-for="direccio in proveidor.direccions_proveidors" class="card p-0 mb-2">
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
                                        v-on:blur="getCodipostal(direccio.cp_id, direccio)"  @keydown.enter="getCodipostal(direccio.cp_id, direccio)" />
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
                        <Button v-if="showAddButton" @click="addProveidor" label="Guardar" icon="pi pi-check" text="" />
                        <Button v-if="showUpdateButton" @click="updateProveidor" label="Actualitzar" icon="pi pi-check"
                            text="" />
                    </template>
                </Dialog>


                <!-- DIALOG PER ESBORRAR  PROVEIDOR -->
                <Dialog v-model:visible="deleteProveidorDialog" :style="{ width: '450px' }" header="Confirma" modal>
                    <div class="flex align-items-center justify-content-center">
                        <i class="pi pi-exclamation-triangle mr-3" style="font-size: 2rem" />
                        <span> Esborrar Proveidor <b>{{ proveidorToDelete.name }}</b>?</span>
                    </div>
                    <template #footer>
                        <Button label="No" icon="pi pi-times" text @click="deleteProveidorDialog = false" />
                        <Button label="Yes" icon="pi pi-check" text @click="confirmDeleteProveidor" />
                    </template>
                </Dialog>


            </div>
        </div>
    </div>
</template>
