<template>

    <!-- Div Client -->
    <div class="grid">
        <div class="col-12 lg:col-8 xl:col-8">
            <div class="card">
                <div class="flex justify-content-between align-items-center mb-5">
                    <h5>Nou Albarà</h5>

                </div>
                <div class="p-fluid formgrid grid">

                    <div class="col-12 pb-3">
                        <label for="clients_id">Id clients </label>

                        <Dropdown v-model="albaran.clients" :options="clients" filter :optionLabel="showNameClient"
                            appendTo="self" placeholder="Client" class="w-full"
                            @change="getClientOrders(albaran.clients.id)">
                        </Dropdown>
                    </div>

                    <div class="col-12 md:col-6">
                        <div class="field">
                            <label for="titulo">Títol</label>
                            <InputText v-model="albaran.titulo" id="titulo" type="text" />
                        </div>
                    </div>

                    <div class="col-12 md:col-6">
                        <div class="field">
                            <label for="descripcion">Descripció</label>
                            <InputText v-model="albaran.descripcion" id="descripcion" type="text" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Div Preus Client -->
        <div class="col-12 lg:col-4 xl:col-4">
            <div class="card">
                <div class="flex justify-content-between align-items-center mb-5">
                    <h5>Preu Final</h5>

                </div>
                <div class="p-fluid formgrid grid">

                    <div class="col-12">
                        <div class="field">
                            <label for="precio">Preu</label>
                            <InputGroup>
                                <InputGroupAddon>
                                    <i class="pi pi-dollar"></i>
                                </InputGroupAddon>
                                <InputText v-model="albaran.precio_id" id="precio_id" type="text" />
                            </InputGroup>
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="iva">Iva</label>
                        <div class="field">
                            <InputGroup>
                                <InputGroupAddon>
                                    <i class="pi pi-percentage"></i>
                                </InputGroupAddon>
                                <InputText v-model="albaran.iva" id="iva" type="text" />
                            </InputGroup>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Llistat ordres -->
    <div class="card">
        <div class="flex justify-content-between align-items-center mb-5">
            <h5>Llistat ordres</h5>
            <div>
                <Button label="Afegir Ordre de Treball" icon="pi pi-plus" class="mr-2" severity="success"
                    @click="orderDialog = true" />
            </div>
        </div>
        <DataTable v-model:selection="selectedOrder" :value="ordenes_trabajo" dataKey="id" :paginator="true" :rows="10"
            :filters="filters"
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



        </DataTable>

    </div>

    <!-- Llistat Materials -->
    <div class="card">
        <div class="flex justify-content-between align-items-center mb-5">
            <h5>Materials</h5>
            <div>
                <Button label="Afegir Material" icon="pi pi-plus" class="mr-2" severity="success"
                    @click="addMaterial()" />
            </div>

        </div>
        <!-- BUSCADOR DE MATERIALS -->
        <div v-for="material in materials" class="card p-0 mb-2">
            <div class="flex flex-column md:flex-row md:justify-content-between md:align-items-center">
                <h5 class="m-0"></h5>
                <IconField iconPosition="left">
                    <InputIcon>
                        <i class="pi pi-search" />
                    </InputIcon>
                    <InputText v-model="filters['global'].value" placeholder="Buscar..." />
                </IconField>
            </div>




            <div class="p-fluid formgrid grid">
                <div class="col-6 md:col-3">
                    <label for="materials_id">Codi </label>
                    <Dropdown v-model="materials_id" :options="materials" filter :optionLabel="showNameClient"
                        optionValue="id" placeholder="Material_id" class="w-full">
                    </Dropdown>
                </div>

                <div class="col-12 md:col-9">
                    <div class="field">
                        <label for="descripcion">Descripció</label>
                        <InputText v-model="materials.descripcion" id="descripcion" type="text" />
                    </div>
                </div>

                <div class="col-6 md:col-3">
                    <div class="field">
                        <label for="titulo">Proveidor</label>
                        <InputText v-model="materials.proveidors_id" id="proveidor" type="text" />
                    </div>
                </div>

                <div class="col-6 md:col-3">
                    <div class="field">
                        <label for="titulo">Marca</label>
                        <InputText v-model="materials.marca_id" id="marca" type="text" />
                    </div>
                </div>

                <div class="col-6 md:col-3">
                    <div class="field">
                        <label for="titulo">Familia</label>
                        <InputText v-model="materials.familia_id" id="familia" type="text" />
                    </div>
                </div>

                <div class="col-6 md:col-3">
                    <div class="field">
                        <label for="titulo">Stock</label>
                        <InputText v-model="materials.stock" id="stock" type="text" />
                    </div>
                </div>

                <div class="col-6 md:col-3">
                    <div class="field">
                        <label for="titulo">Preu Cost</label>
                        <InputText v-model="materials.preciocoste" id="preciocoste" type="text" />
                    </div>
                </div>

                <div class="col-6 md:col-3">
                    <div class="field">
                        <label for="titulo">PVP</label>
                        <InputText v-model="materials.pvp" id="pvp" type="text" />
                    </div>
                </div>

                <div class="col-6 md:col-3">
                    <div class="field">
                        <label for="titulo">Marge</label>
                        <InputText v-model="materials.margen" id="margen" type="text" />
                    </div>
                </div>

                <!-- <div class="col-6 md:col-3">
                    <div class="field">
                        <label for="titulo">Unitats</label>
                        <InputNumber v-model="albaran.stock" inputId="horas" mode="decimal" showButtons :min="0"
                            :max="100" />
                    </div>
                </div> -->
            </div>
        </div>
    </div>


    <div class="card p-fluid">
        <div class="field col-6 md:col-3">


            <!-- Al no haber fotos, pots enviar la info amb el @click -->
            <Button @click="addAlbaran" label="guardar"></Button>
        </div>
    </div>




    <!-- DIALOG PER SELECCIONAR ORDRES A AFEGIR -->
    <Dialog v-model:visible="orderDialog" header="Afegir orders de treball" :modal="true" class="p-fluid">
        <DataTable v-model:selection="selectedOrder" :value="ordenes_trabajo" dataKey="id" :paginator="true" :rows="10"
            :filters="filters"
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
        </DataTable>


        <template #footer>
            <Button label="Cancel.la" icon="pi pi-times" text="" @click="orderDialog = false" />
        </template>
    </Dialog>


</template>

<script setup>
import axios from 'axios';
import { ref } from 'vue';
import InputGroup from 'primevue/inputgroup';
import InputGroupAddon from 'primevue/inputgroupaddon';
import { useToast } from "primevue/usetoast";
import Button from 'primevue/button';
import DataTable from 'primevue/datatable';
import useOrders from "@/composables/orders";
import useAlbarans from "@/composables/albarans";
import { onMounted, onBeforeMount } from 'vue';
import { FilterMatchMode } from 'primevue/api';
import useMaterials from '../../../composables/materials';


const { addAlbaran, albaran, addMaterial, showNameClient } = useAlbarans();
const { getOrders, getClientOrders, ordenes_trabajo } = useOrders();
const { materials, getMaterials } = useMaterials();
const selectedOrder = ref([]);
const clients = ref(null);
const users = ref(null);
const filters = ref({});
const orderDialog = ref(false);


const toast = useToast();
const search = ref();


onMounted(() => {
    // getOrders()
});

onBeforeMount(() => {

    const initFilters = () => {
        filters.value = {
            global: { value: null, matchMode: FilterMatchMode.CONTAINS }
        };
    };

    initFilters();

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

<style></style>
