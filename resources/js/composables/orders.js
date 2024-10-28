import { ref } from 'vue';
export default function useOrders() {

    const order = ref({ client: {} });
    const ordenes_trabajo = ref([]);

    const getOrders = async () => {
        try {
            const response = await axios.get('/api/ordenes_trabajo');
            ordenes_trabajo.value = response.data;
        } catch (error) {
            console.error('Error al obtener datos:', error);
        }
    }

    const getOrder = async (id) => {
        try {
            const response = await axios.get('/api/ordenes_trabajo/' + id);
            order.value = response.data;
        } catch (error) {
            console.error('Error al obtener datos:', error);
        }
    }

    function getClientOrders(id)
    {
        console.log(id)
        axios.get('/api/ordenes_trabajo/showById/' + id)
        .then(response => {
            console.log(response);
            ordenes_trabajo.value = response.data;
        })
        .catch(error => {
            console.log(error);
        })
    }


    const updateOrder = async () => {
        console.log(order.value)

        axios.put('/api/ordenes_trabajo/' + order.value.id, order.value)
            .then(response => {
                replaceResult(order.id, response.data.data)

            }).catch(error => {
                console.error('Error al actualizar datos:', error);
            })
    }


    function replaceResult(id, newValue) {
        const index = ordenes_trabajo.value.findIndex(order => ordenes_trabajo.id === id)
        if(index !== -1){
            ordenes_trabajo.value[index] = newValue;
            console.log('Ordre amb ID ${id} reemplaçat amb èxit.')
        }
        else{
            console.log('Ordre amb ID ${id} no trobat.')
        }

    }

    return {
        order,
        ordenes_trabajo,
        getOrders,
        getOrder,
        updateOrder,
        getClientOrders

    }
}
