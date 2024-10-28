import { ref, inject } from 'vue'
import { useRouter } from 'vue-router'
export default function usematerials() {
    const materials = ref([])
    const material = ref({
        img: ''
    })
    const router = useRouter()
    const validationErrors = ref({})
    const isLoading = ref(false)
    const swal = inject('$swal')
    //imagenes


    const getMaterials = async () => {
        axios.get('/api/materials')
            .then(response => {
                console.log(response.data);
                materials.value = response.data;
            })
    }


    const storeMaterial = async () => {

        console.log(1)
        if (isLoading.value) return;

        isLoading.value = true
        validationErrors.value = {}
        console.log(2)
        let serializedMaterial = new FormData()
        for (let item in material.value) {
            if (material.value.hasOwnProperty(item)) {
                serializedMaterial.append(item, material.value[item])
            }
        }

        axios.post('/api/materials', serializedMaterial, {
            headers: {
                "content-type": "multipart/form-data"
            }
        })
            .then(response => {
                console.log(3)
                materials.value.push(response.data.data)
                // router.push({ name: 'material.index' })
                swal({
                    icon: 'success',
                    title: 'material saved successfully'
                })
            })
            .catch(error => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                }
            })
            .finally(() => isLoading.value = false)
    }

    const updateMaterial = async () => {
        if (isLoading.value) return;

        isLoading.value = true
        validationErrors.value = {}

        axios.post('/api/materials/' + material.value.id, material.value, {
            headers: {
                "content-type": "multipart/form-data"
            }
        })
            .then(response => {
                replaceResult(material.value.id, response.data.data)
                materialDialog.value = false
                router.push({ name: 'materials.index' })
                console.log(response);
                swal({
                    icon: 'success',
                    title: 'Material updated successfully'
                })

            })
            .catch(error => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                }
            })
            .finally(() => isLoading.value = false)
    }

    function replaceResult(id, newValue) {

        const index = materials.value.findIndex(material => material.id === id);
        if (index !== -1) {
            materials.value[index] = newValue;
            console.log(`Objeto con ID ${id} reemplazado con éxito.`);
        } else {
            console.log(`No se encontró ningún objeto con ID ${id}. No se realizó ningún reemplazo.`);
        }
    }

    return {
        materials,
        material,
        //getExercises,
        getMaterials,
        storeMaterial,
        updateMaterial,
        //deleteExercise,
        validationErrors,
        isLoading,
        router
    }
}
