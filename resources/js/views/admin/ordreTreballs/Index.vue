<!-- BARRA D'EINES -->
<template>
    <div class="grid">
        <div class="col-12">
            <div class="card">

                <!-- Toolbar amb botons NEW i EXPORT -->
                <Toolbar class="mb-4">
                    <template v-slot:start>
                        <div class="my-2">
                            <Button label="Nova Ordre Treball" icon="pi pi-plus" class="mr-2" severity="success"
                                @click="openNew" />
                        </div>
                    </template>

                    <template v-slot:end>

                        <!-- <Button label="Imprimir" icon="pi pi-print" class="mr-2" severity="primary" @click="router.push({ name: 'ordreTreballs.print' })" /> -->
                        <Button label="Imprimir" icon="pi pi-print" class="mr-2" severity="primary"
                            @click="openPrint" />

                    </template>
                </Toolbar>

                <!-- PAGINADOR AL FINAL DEL LLISTAT DE ORDRES -->
                <DataTable v-model:selection="selectedOrder" :value="ordenes_trabajo" dataKey="id" :paginator="true"
                    :rows="10" :filters="filters"
                    paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                    :rowsPerPageOptions="[5, 10, 25]"
                    currentPageReportTemplate="Ordres  de la {first} a la {last} de {totalRecords} Ordres Actives">



                    <!-- BUSCADOR DE ORDRES -->
                    <template #header>
                        <div class="flex flex-column md:flex-row md:justify-content-between md:align-items-center">
                            <h5 class="m-0">Ordres actives</h5>
                            <IconField iconPosition="left">
                                <InputIcon>
                                    <i class="pi pi-search" />
                                </InputIcon>
                                <InputText v-model="filters['global'].value" placeholder="Buscar..." />
                            </IconField>
                        </div>
                    </template>


                    <!-- HEADER CAMPS QUE ES MOSTREN -->

                    <Column selectionMode="multiple" headerStyle="width: 3rem"></Column>
                    <Column field="id" header="Order number" :sortable="true">
                        <template #body="slotProps">
                            <span class="p-column-title">Número d'ordre</span>
                            {{ slotProps.data.id }}
                        </template>
                    </Column>

                    <Column field="name" header="Nom Client" :sortable="true">
                        <template #body="slotProps">
                            <span class="p-column-title">NomClient</span>
                            {{ slotProps.data.client.name + ' ' + slotProps.data.client.surname1 }}
                        </template>
                    </Column>

                    <Column field="telefon" header="Telèfon" :sortable="true">
                        <template #body="slotProps">
                            <span class="p-column-title">Telefon</span>
                            {{ slotProps.data.client.telefon }}
                        </template>
                    </Column>
                    <Column field="operari" header="Operari" sortable>
                        <template #body="slotProps">
                            <span class="p-column-title">Operari</span>
                            <Tag severity="info">{{ slotProps.data.operario.name }}</Tag>
                        </template>
                    </Column>
                    <Column field="dia" header="Dia" sortable>
                        <template #body="slotProps">
                            <span class="p-column-title">Dia</span>
                            {{ slotProps.data.date_open }}
                        </template>
                    </Column>


                    <Column field="acciones" header="Accions" :sortable="false" style="width:115px;">
                        <template #body="slotProps">
                            <Button icon="pi pi-pencil" class="mr-2" severity="success" rounded
                                @click="openEdit(slotProps.data)" />
                            <Button icon="pi pi-trash" severity="warning" rounded
                                @click="deleteOrder(slotProps.data, slotProps.index)" />
                        </template>
                    </Column>
                </DataTable>


                <!-- DIALOG PER CREAR NOVA ORDRE DE TREBALL-->
                <Dialog v-model:visible="orderDialog" :style="{ width: '600px' }" :header="dialogHeaderText"
                    class="p-fluid">


                    <!--v-model enllaça el valor seleccionat en el desplegable amb la propietat client_id de l'obj. orden_trabajo.
                    options  passa les opcions disponibles per al desplegable, que es troben a la variable clients.
                    optionLabel  Indica que la etiqueta mostrada per a cada opció serà el camp nif de cada element de clients.
                    optionValue: el valor associat a cada opció seleccionada serà el camp id de cada element de clients.
                    -->

                    <!-- <Dropdown v-model="order.client_id" :options="clients" filter :optionLabel="showNameClient"
                        optionValue="id" placeholder="Nif client" class="w-full">
                    </Dropdown> -->
                    <div class="mb-3">
                        <!-- {{ order.client }} -->
                        <Dropdown v-model="order.client" :options="clients" filter :optionLabel="showNameClient"  dataKey="id"
                            appendTo="self" placeholder="Nif client" class="w-full">
                        </Dropdown>
                    </div>
                    <!-- {{ order.client }} -->
                    <div class="mb-3">
                        <Dropdown v-model="order.direccion_id" :options="order.client.direccions" filter dataKey="id"
                            :optionLabel="showCarrer" optionValue="id" placeholder="Direcció" class="w-full">
                        </Dropdown>
                    </div>


                    <div class="field">
                        <label for="descripcion">Descripció</label>
                        <Textarea v-model="order.descripcion" id="descripcion" type="text" autoResize rows="3"
                            cols="30" />
                    </div>
                    <div class="field">
                        <label>Data Inici</label><span class="text-danger">*</span>
                        <input class="form-control" v-model="order.date_open" type="datetime-local" name="date_open" />
                    </div>
                    <div class="field">
                        <label>Data Finalització</label><span class="text-danger">*</span>
                        <input class="form-control" v-model="order.date_close" type="datetime-local"
                            name="date_close" />
                    </div>


                    <div class="field">
                        <label for="horas" class="font-bold block mb-2"> Hores Previstes </label>
                        <InputNumber v-model="order.horas" inputId="horas" mode="decimal" showButtons :min="0"
                            :max="100" />
                    </div>

                    <!-- Creem una funció showNameOperari per mostrar nom i cognoms  -->
                    <Dropdown v-model="order.operario_id" :options="users" filter :optionLabel="showNameOperari"
                        optionValue="id" placeholder="Operari" class="w-full md:w-14rem">
                    </Dropdown>


                    <template #footer>
                        <Button label="Cancel.la" icon="pi pi-times" text="" @click="hideDialog" />
                        <Button v-if="showAddButton" @click="addOrder" label="Guardar" icon="pi pi-check" text="" />
                        <Button v-if="showUpdateButton" @click="updateOrderAction" label="Actualitzar"
                            icon="pi pi-check" text="" />
                    </template>
                </Dialog>


                <!-- DIALOG PER ESBORRAR  ORDRE DE TREBALL -->
                <Dialog v-model:visible="deleteOrderDialog" :style="{ width: '450px' }" header="Confirma" modal>
                    <div class="flex align-items-center justify-content-center">
                        <i class="pi pi-exclamation-triangle mr-3" style="font-size: 3rem" />
                        <span>
                            Esborrar Ordre <b>{{ orderToDelete.id }}</b>?
                        </span>
                    </div>
                    <template #footer>
                        <Button label="No" icon="pi pi-times" text @click="deleteOrderDialog = false" />
                        <Button label="Yes" icon="pi pi-check" text @click="confirmDeleteOrder" />
                    </template>
                </Dialog>


                <!-- DIALOG PER IMPRIMIR NOVA ORDRE DE TREBALL-->
                <Dialog v-model:visible="printDialog" maximizable modal :style="{ width: '50rem' }"
                    :breakpoints="{ '1199px': '75vw', '575px': '90vw' }" :header="dialogHeaderText" class="p-fluid">

                    <div id='printable_div_id'>
                        <!-- Div amb les dades del negoci -->
                        <div class="row mb-4">
                            <div class="col-6">
                                <img class="card col-10" src="/images/logo.jpg">
                            </div>
                            <div class="col-6">
                                <fieldset>
                                    <legend>Instal·lacions Beneït S.L.</legend>
                                    <p class="m-0">C. de Cartagena, 309,</p>
                                    <p class="m-0">L'Eixample, 08025 Barcelona</p>
                                    <p class="m-0">CIF: 998227665S</p>
                                    <p class="m-0">Telèfon: 934 36 38 16</p>
                                    <p class="m-0">info@beneitinstalacions.com</p>
                                </fieldset>
                            </div>
                            <div class="col-6">
                                <fieldset>
                                    <legend>Dades Client</legend>

                                    <p class="m-0"><span class="p-column-title">Nif: {{ selectedOrder[0].client.nif
                                            }}</span>
                                    </p>
                                    <p class="m-0"><span class="p-column-title">Client: {{
                                        selectedOrder[0].client.name }}
                                            {{ selectedOrder[0].client.surname1 }}</span></p>
                                    <p class="m-0"><span class="p-column-title">Adreça</span></p>
                                    <p class="m-0"><span class="p-column-title">Telèfon:
                                            {{ selectedOrder[0].client.telefon }}</span></p>
                                    <p class="m-0"><span class="p-column-title">Email: {{
                                        selectedOrder[0].client.email }}</span></p>
                                </fieldset>
                            </div>

                        </div>

                        <DataTable :value="selectedOrder" dataKey="id" class="mb-4">

                            <Column field="id" header="Order number">
                                <template #body="slotProps">
                                    <span class="p-column-title">Número d'ordre</span>
                                    {{ slotProps.data.id }}
                                </template>
                            </Column>

                            <Column field="id" header="Descripció">
                                <template #body="slotProps">
                                    <span class="p-column-title">Descripció</span>
                                    {{ slotProps.data.descripcion }}
                                </template>
                            </Column>

                            <Column field="operari" header="Operari">
                                <template #body="slotProps">
                                    <span class="p-column-title">Operari</span>
                                    <Tag severity="info">{{ slotProps.data.operario.name }}</Tag>
                                </template>
                            </Column>
                            <Column field="dia" header="Dia">
                                <template #body="slotProps">
                                    <span class="p-column-title">Dia</span>
                                    {{ slotProps.data.date_open }}
                                </template>
                            </Column>

                            <Column field="horas" header="Hores">
                                <template #body="slotProps">
                                    <span class="p-column-title">Hores</span>
                                    {{ slotProps.data.horas }}
                                </template>
                            </Column>
                        </dataTable>

                        <div class="mb-4">
                            <fieldset>
                                <legend>Comentaris</legend>
                                <Textarea class="mb-4" v-model="value" rows="5" cols="84" />
                            </fieldset>
                        </div>

                        <!-- Div amb espai per les firmes -->
                        <div class="row">
                            <div class=" col-6 ">
                                <fieldset>
                                    <legend>Firma Instalador</legend>
                                    <Textarea class="mb-4" v-model="value" rows="6" cols="30" />
                                </fieldset>
                            </div>
                            <div class=" col-6">
                                <fieldset>
                                    <legend>Firma Client</legend>
                                    <Textarea class="mb-4" v-model="value" rows="6" cols="30" />
                                </fieldset>
                            </div>
                        </div>

                    </div>

                    <!-- Botó d'imprimir -->
                    <div class="row mt-4 print-hide">
                        <div class="col-md-12 text-center">
                            <button class="btn btn-primary" @click="printdiv('printable_div_id');"
                                style="align-items: center;">
                                <i class="pi pi-print"></i> Imprimir
                            </button>
                        </div>
                    </div>

                </Dialog>


            </div>
        </div>
    </div>

    <div class="to_print"></div>
</template>

<script setup>
import { FilterMatchMode } from 'primevue/api';
import { ref, onMounted, onBeforeMount } from 'vue';
import { useToast } from 'primevue/usetoast';
import Message from 'primevue/message';
import useOrders from "@/composables/orders";
import { useRouter } from 'vue-router';


const router = useRouter();
const toast = useToast();
const clients = ref(null);
const users = ref(null);
const orderDialog = ref(false);
const printDialog = ref(false);
const deleteOrderDialog = ref(false);
const client = ref({});

const filters = ref({
    'global': { value: null, matchMode: FilterMatchMode.CONTAINS },
});
const initFilters = () => {
    filters.value = {
        global: { value: null, matchMode: FilterMatchMode.CONTAINS }
    };
};
const submitted = ref(false);
const orderToDelete = ref({});
const selectedOrder = ref([]);
const indexToDelete = ref(-1);
const dialogHeaderText = ref("");
const showAddButton = ref(true);
const showUpdateButton = ref(false);
const { getOrders, updateOrder, ordenes_trabajo, order } = useOrders()

const showNameOperari = (operari) => {
    return operari.name + ' ' + operari?.surname1
};

const showNameClient = (client) => {
    console.log(client)
    return client.nif + ' ' + client.name + ' ' + client?.surname1
};
const showCarrer = (direccion) => {
    console.log(direccion)
    return direccion.carrer + '' + direccion.numero + '' + direccion.pis
};

const hideDialog = () => {
    orderDialog.value = false;
    submitted.value = false;
};

const openNew = () => {
    order.value = { client: {} };
    orderDialog.value = true;
    dialogHeaderText.value = "Nova Ordre de Treball";
    showUpdateButton.value = false;
    showAddButton.value = true;
};
const openPrint = () => {
    order.value = { client: {} };
    printDialog.value = true;
    dialogHeaderText.value = "Imprimir Ordre de Treball";

};

const openEdit = (orderToEdit) => {
    orderDialog.value = true
    order.value = JSON.parse(JSON.stringify({ ...orderToEdit }));
    dialogHeaderText.value = "Editar Ordre de Treball";
    showUpdateButton.value = true;
    showAddButton.value = false;
}

const updateOrderAction = async () => {
    await updateOrder()
    hideDialog()
}

const confirmDeleteOrder = () => {
    console.log(orderToDelete.value.id);
    axios.delete('/api/ordenes_trabajo/' + orderToDelete.value.id)
        .then(response => {
            ordenes_trabajo.value.splice(indexToDelete.value, 1)
            deleteorderDialog.value = false;
            toast.add({ severity: 'success', summary: 'Successful', detail: 'Ordre de Treball Eliminada', life: 3000 });
        })
}

const deleteorder = (order, index) => {
    deleteOrderDialog.value = true
    indexToDelete.value = index;
    orderToDelete.value = order;
}

function addOrder() {

    order.value.client_id =order.value.client.id;
    order.value.direccion_id =order.value.client.direccion_id;


    axios.post('/api/ordenes_trabajo', order.value)
        .then(response => {
            //afegim a la resposta l'ultim objecte afegit
            ordenes_trabajo.value.push(response.data.data)
            console.log(response.data.data);
            orderDialog.value = false
            //order.value = response.data;
        })
        .catch(error => {
            console.log(error);
        })
}
function printdiv(elem) {
    window.print();
}


function closeUpdateDialog() {
    orderDialog.value = false;
}

onMounted(() => {
    getOrders()
});

onBeforeMount(() => {
    //initFilters();


    // axios.get('/api/ordenes_trabajo')
    //     .then(response => {
    //         console.log(response);
    //         ordenes_trabajo.value = response.data;
    //     })
    //     .catch(error => {
    //         console.error('Error al obtener datos:', error);
    //     });

    axios.get('/api/clients')
        .then(response => {
            console.log(response);
            clients.value = response.data;
        })
        .catch(error => {
            console.error('Error al obtener datos:', error);
        });

    axios.get('/api/users')
        .then(response => {
            console.log(response);
            users.value = response.data.data;
        })
        .catch(error => {
            console.error('Error al obtener datos:', error);
        });
});


</script>


<style>
.mb-4 {
    margin-bottom: 1rem;
}

@page {
    size: A4;
    margin: 1cm;
}


@media print {
    .print-content {
        font-size: 10pt
    }

    /* Amaga el botó d'impressió */
    .print-hide,
    .p-dialog-header {
        display: none;
    }

    .p-dialog-header {
        display: hidden;
    }

    .p-dialog {
        box-shadow: none;
        border: 0;
        margin: 0;
        padding: 0;
    }
}

/* Mostra només el contingut principal */



body {
    margin: 0;
    padding: 0;
}

.container {
    padding: 1rem;
}
</style>
