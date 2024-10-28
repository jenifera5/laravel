<script setup>
import { FilterMatchMode } from 'primevue/api';
import { ref, onMounted, onBeforeMount } from 'vue';
// import ProductService from '@/service/ProductService';
import { useToast } from 'primevue/usetoast';
import Message from 'primevue/message';
import InputGroup from 'primevue/inputgroup';
import InputGroupAddon from 'primevue/inputgroupaddon';
import Image from 'primevue/image';
import DropZone from "@/components/DropZone.vue";
import useMaterials from '../../../composables/materials';

const toast = useToast();
const materialDialog = ref(false);
const deleteMaterialDialog = ref(false);
const filters = ref({});
const submitted = ref(false);
const materialToDelete = ref({});
const indexToDelete = ref(-1);
const showAddButton = ref(true);
const showUpdateButton = ref(false);
const dialogHeaderText = ref("");


const { getMaterials, updateMaterial, storeMaterial, materials, material, validationErrors } = useMaterials();

const hideDialog = () => {
    materialDialog.value = false;
    submitted.value = false;
};

const openEdit = (materialToEdit) => {
    materialDialog.value = true
    //material.value = materialToEdit;
    material.value = JSON.parse(JSON.stringify({ ...materialToEdit }));
    dialogHeaderText.value = "Editar Material";
    showUpdateButton.value = true;
    showAddButton.value = false;
}

const addMaterialView = async () => {
    await storeMaterial()
    hideDialog()
}

const updateMaterialView = async () => {
    await updateMaterial()
    hideDialog()
}

const confirmDeleteMaterial = () => {
    console.log(materialToDelete.value.id);
    axios.delete('/api/materials/' + materialToDelete.value.id)
        .then(response => {
            materials.value.splice(indexToDelete.value, 1)
            deleteMaterialDialog.value = false;
            toast.add({ severity: 'sucess', summary: 'Successful', detail: 'material Esborrat', life: 3000 });
        })
}

const deleteMaterial = (material, index) => {
    deleteMaterialDialog.value = true
    indexToDelete.value = index;
    materialToDelete.value = material;
}

const openNew = () => {
    material.value = {};
    //submitted.value = false;
    materialDialog.value = true;
    dialogHeaderText.value = "Nou materials";
    showUpdateButton.value = false;
    showAddButton.value = true;
};


onMounted(() => {
    getMaterials();
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
                            <Button label="Nou Material" icon="pi pi-plus" class="mr-2" severity="success"
                                @click="openNew" />
                        </div>
                    </template>

                    <template v-slot:end>
                        <Button label="Export" icon="pi pi-upload" severity="help" @click="exportCSV($event)" />
                    </template>
                </Toolbar>


                <DataTable v-model:filters="filters" :value="materials" dataKey="id" :paginator="true" :rows="10"
                    paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport RowsPerPageDropdown"
                    :rowsPerPageOptions="[5, 10, 25]"
                    currentPageReportTemplate="Materials del {first} a {last} of {totalRecords} clients"
                    :globalFilterFields="['codigo', 'description', 'stock', 'numero_serie']">
                    <!-- BUSCADOR DE PRODUCTES -->
                    <template #header>
                        <div class="flex flex-column md:flex-row md:justify-content-between md:align-items-center">
                            <h5 class="m-0">Llistat Materials</h5>
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
                    <Column field="codigo" header="Codigo" :sortable="true" headerStyle="width:24%; min-width:10rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">Codigo</span>
                            {{ slotProps.data.codigo }}
                        </template>
                    </Column>
                    <Column field="description" header="Description" :sortable="true"
                        headerStyle="width:24%; min-width:10rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">Description</span>
                            {{ slotProps.data.description }}
                        </template>
                    </Column>
                    <Column field="stock" header="Stock" :sortable="true" headerStyle="width:24%; min-width:10rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">Stock</span>
                            {{ slotProps.data.stock }}
                        </template>
                    </Column>
                    <Column field="numero_serie" header="NumeroSerie" :sortable="true"
                        headerStyle="width:24%; min-width:10rem;">
                        <template #body="slotProps">
                            <span class="p-column-title">NumeroSerie</span>
                            {{ slotProps.data.numero_serie }}
                        </template>
                    </Column>
                    <Column field="img" header="img" :sortable="true" headerStyle="width:24%; min-width:10rem;">
                        <template #body="slotProps">
                            <img :src="slotProps.data.media[0]?.original_url" :alt="slotProps.data.media[0]?.name"
                                class="w-6rem border-round" />
                            <span class="p-column-title">Img</span>

                        </template>
                    </Column>
                    <Column field="acciones" header="Acciones" :sortable="false" headerStyle="min-width:10rem;">
                        <template #body="slotProps">
                            <Button icon="pi pi-pencil" class="mr-2" severity="success" rounded
                                @click="openEdit(slotProps.data)" />
                            <Button icon="pi pi-trash" class="mt-2" severity="warning" rounded
                                @click="deleteMaterial(slotProps.data, slotProps.index)" />
                        </template>
                    </Column>
                </DataTable>




                <!-- DIALOG PER CREAR NOU MATERIAL -->
                <Dialog v-model:visible="materialDialog" :style="{ width: '1200px' }" :header="dialogHeaderText"
                    :modal="true" class="p-fluid">
                    <!-- <img :src="'/demo/images/product/' + product.image" :alt="product.image" v-if="product.image" width="150" class="mt-0 mx-auto mb-5 block shadow-2" /> -->
                    <div class="field">
                        <label for="codigo">Codigo</label>
                        <InputText id="1233" v-model.trim="material.codigo" required="true" autofocus
                            :invalid="submitted && !material.codigo" />
                        <small class="p-invalid" v-if="submitted && !material.codigo">El codic es obligatori.</small>
                    </div>
                    <div class="field">
                        <label for="description">Description</label>
                        <InputText v-model="material.description" id="description" type="text" />
                        <small class="p-invalid" v-if="submitted && !material.description">la descripcio es
                            obligatoria.</small>
                    </div>
                    <div class="field">
                        <label for="nif">Stock</label>

                        <InputNumber v-model="material.stock" id="stock" type="text" :min="0" />
                        <small class="p-invalid" v-if="submitted && !material.stock">El stock es obligatori.</small>
                    </div>
                    <div class="field">
                        <label for="numero_serie">Numero Serie</label>
                        <InputText v-model="material.numero_serie" id="numero_serie" type="text" />
                        <small class="p-invalid" v-if="submitted && !material.numero_serie">El codic es
                            obligatori.</small>
                    </div>
                    <div class="field">
                        <label for="pvp">PVP</label>
                        <InputGroup>
                            <InputGroupAddon>
                                <i class="pi pi-dollar"></i>
                            </InputGroupAddon>
                            <InputNumber v-model="material.pvp" id="pvp" currency="EUR" locale="es-ES" />
                        </InputGroup>
                    </div>
                    <div class="field">
                        <label for="preciocoste">Precio Coste</label>
                        <InputGroup>
                            <InputGroupAddon>
                                <i class="pi pi-dollar"></i>
                            </InputGroupAddon>
                            <InputText v-model="material.preciocoste" id="preciocoste" type="text" />
                        </InputGroup>
                    </div>
                    <div class="field">
                        <label for="encurs">enCurs</label>
                        <Checkbox v-model="material.encurs" :binary="true" />
                        <!-- <InputText v-model="proveidor.encurs" id="encurs" type="text" />  -->
                    </div>
                    <div class="field">
                        <label for="observacions">Observacions</label>
                        <InputText v-model="material.observacions" id="observacions" type="text" />
                    </div>

                    <div class="field">
                        <label for="img">Img </label>
                        <DropZone v-model="material.img" id="img" type="text" />
                        <div class="text-danger mt-1">
                            <div v-for="message in validationErrors?.img">
                                {{ message }}
                            </div>
                        </div>
                    </div>
                    <template #footer>
                        <Button label="Cancel.la" icon="pi pi-times" text="" @click="hideDialog" />
                        <Button v-if="showAddButton" @click="addMaterialView" label="Guardar" icon="pi pi-check"
                            text="" />
                        <Button v-if="showUpdateButton" @click="updateMaterialView" label="Actualitzar" icon="pi pi-check"
                            text="" />
                    </template>
                </Dialog>
                <!-- DIALOG PER ESBORRAR  PROVEIDOR -->
                <Dialog v-model:visible="deleteMaterialDialog" :style="{ width: '450px' }" header="Confirma" modal>
                    <div class="flex align-items-center justify-content-center">
                        <i class="pi pi-exclamation-triangle mr-3" style="font-size: 2rem" />
                        <span v-if="product"> Esborrar Material <b>{{ materialToDelete.codigo }}</b>?</span>
                    </div>
                    <template #footer>
                        <Button label="No" icon="pi pi-times" text @click="deleteMaterialDialog = false" />
                        <Button label="Yes" icon="pi pi-check" text @click="confirmDeleteMaterial" />
                    </template>
                </Dialog>

                <!-- <Dialog v-model:visible="deleteProveidorsDialog" :style="{ width: '450px' }" header="Confirm" :modal="true">
                    <template #footer>
                        <Button label="No" icon="pi pi-times" text @click="deleteProveidorsDialog = false" />
                        <Button label="Yes" icon="pi pi-check" text @click="confirmDeleteProveidor" />
                    </template>
                </Dialog>-->

            </div>
        </div>
    </div>
</template>




// function updateMaterial() {
// if (isLoading.value) return;

// isLoading.value = true
// validationErrors.value = {}

// axios.post('/api/materials/' + material.value.id, material.value, {
// headers: {
// "content-type": "multipart/form-data"
// }
// })
// .then(response => {
// replaceResult(material.value.id, response.data.data)
// materialDialog.value = false
// router.push({ name: 'materials.index' })
// console.log(response);
// swal({
// icon: 'success',
// title: 'Material updated successfully'
// })

// })
// .catch(error => {
// if (error.response?.data) {
// validationErrors.value = error.response.data.errors
// }
// })
// .finally(() => isLoading.value = false)
// }



// function addMaterial() {
// if (isLoading.value) return;

// isLoading.value = true
// validationErrors.value = {}

// let serializedMaterial = new FormData()
// for (let item in material.value) {
// if (material.value.hasOwnProperty(item)) {
// serializedMaterial.append(item, material.value[item])
// }
// }

// axios.post('/api/materials', serializedMaterial, {
// headers: {
// "content-type": "multipart/form-data"
// }
// })
// .then(response => {

// materials.value.push(response.data.data)
// console.log(response.data.data);
// materialDialog.value = false
// router.push({ name: 'material.index' })
// swal({
// icon: 'success',
// title: 'material saved successfully'
// })
// })
// .catch(error => {
// if (error.response?.data) {
// validationErrors.value = error.response.data.errors
// }
// })
// .finally(() => isLoading.value = false)



// }
