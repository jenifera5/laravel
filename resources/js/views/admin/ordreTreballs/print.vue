<template>
    <div id='printable_div_id'>
        <!-- Div amb les dades del negoci -->
        <div class="row mb-4">
            <div class="col-4">
                <fieldset>
                    <legend>Instal·lacions Beneït</legend>
                    <p class="m-0">C. de Cartagena, 309,</p>
                    <p class="m-0">L'Eixample, 08025 Barcelona</p>
                    <p class="m-0">CIF: 998227665S</p>
                    <p class="m-0">Telèfon: 934 36 38 16</p>
                    <p class="m-0">info@beneitinstalacions.com</p>
                </fieldset>
            </div>
            <div class="col-4">
                <fieldset>
                    <legend>Dades Client</legend>

                    <p class="m-0"><span class="p-column-title">Nif</span></p>
                    <p class="m-0"><span class="p-column-title">Nom</span></p>
                    <p class="m-0"><span class="p-column-title">Adreça</span></p>
                    <p class="m-0"><span class="p-column-title">Telèfon</span></p>
                    <p class="m-0"><span class="p-column-title">email</span></p>
                </fieldset>
            </div>
            <div class="col-4">
                <img src="logo.jpg">
            </div>
        </div>

        <dataTable class="mb-4">
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
    <div class="row mt-4 print-button">
        <div class="col-md-12 text-center">
            <button class="btn btn-primary" @click="printdiv('printable_div_id');" style="align-items: center;">
                <i class="pi pi-print"></i> Imprimir
            </button>
        </div>
    </div>
</template>

<!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->

<script setup>
import { ref, onMounted } from "vue";
import useOrders from "@/composables/orders";


const { getOrder, getOrders, storeOrder, updateOrder, deleteOrder } = useOrders()

onMounted(() => {
    getOrders()
})

function printdiv(elem) {
    var header_str = '<html><head><title>' + document.title + '</title></head><body>';
    var footer_str = '</body></html>';
    var new_str = document.getElementById(elem).innerHTML;
    var old_str = document.body.innerHTML;
    document.body.innerHTML = header_str + new_str + footer_str;
    window.print();
    document.body.innerHTML = old_str;
    return false;
}

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
    .print-button {
        display: none;
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
