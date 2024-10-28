import { ref } from 'vue';
export default function useAlbarans() {

    //DECLARACIÓ DE CONSTANTS:

    const albaran = ref({ materials: [] });
    const client = ref({});
    const clients = ref(null);


const showIdClient = (client) => {
    console.log(client)
    return client.id + ' ' + client.name + ''
};
const showNameClient = (client) => {
    console.log(client)
    return client.nif + ' ' + client.name + ' ' + client?.surname1
};
const addMaterial = () => {
    albaran.value.materials.push({})
};




// CRIDES A AXIOS

axios.get('/api/clients')
    .then(response => {
        console.log(response);
        clients.value = response.data;
    })
    .catch(error => {
        console.error('Error al obtener datos:', error);
    });

    //FUNCIONS:

    function addAlbaran() {
        console.log('clic');
        axios.post('/api/albarans', albaran.value)
            .then(response => {
                console.log(response);
                //proveidor.value = response.data;
            })
            .catch(error => {
                console.log(error);
            })
    }


    return{
        albaran,
        client,
        clients,
        showIdClient,
        addAlbaran,
        addMaterial,
        showNameClient,

    }
}

