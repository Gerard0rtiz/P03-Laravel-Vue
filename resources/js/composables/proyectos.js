import { ref, inject } from 'vue'
import { useRouter } from 'vue-router'

export default function useProyectos() {
    const proyectos = ref({})
    const proyecto = ref({
        titulo: '',
        descripcion: '',
        idUser: ''
    })
    const router = useRouter()
    const validationErrors = ref({})
    const isLoading = ref(false)
    const swal = inject('$swal')

    const getProyectos = async (
        page = 1,
        search_category = '',
        search_id = '',
        search_title = '',
        search_content = '',
        search_global = '',
        order_column = 'created_at',
        order_direction = 'desc'
    ) => {
        axios.get('/api/posts?page=' + page +
            '&search_category=' + search_category +
            '&search_id=' + search_id +
            '&search_title=' + search_title +
            '&search_content=' + search_content +
            '&search_global=' + search_global +
            '&order_column=' + order_column +
            '&order_direction=' + order_direction)
            .then(response => {
                console.log(response.data);
                proyectos.value = response.data;
            })
    }

    const getProyecto = async (id) => {
        axios.get('/api/proyecto/' + id)
            .then(response => {
                proyecto.value = response.data.data;
            })
    }

    const storeProyecto = async (proyecto) => {
        if (isLoading.value) return;

        isLoading.value = true
        validationErrors.value = {}

        let serializedProyecto = new FormData()
        for (let item in post) {
            if (proyecto.hasOwnProperty(item)) {
                serializedProyecto.append(item, proyecto[item])
            }
        }

        axios.post('/api/proyectos', serializedProyecto,{
            headers: {
                "content-type": "multipart/form-data"
            }
        })
            .then(response => {
                router.push({name: 'proyectos.index'})
                swal({
                    icon: 'success',
                    title: 'Proyecto guardado correctamente'
                })
            })
            .catch(error => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                }
            })
            .finally(() => isLoading.value = false)
    }

    const updateProyecto = async (proyecto) => {
        if (isLoading.value) return;

        isLoading.value = true
        validationErrors.value = {}
        console.log(proyecto);
        axios.put('/api/proyectos/' + proyecto.id, proyecto)
            .then(response => {
                router.push({name: 'proyectos.index'})
                swal({
                    icon: 'success',
                    title: 'Proyecto actualizado correctamente'
                })
            })
            .catch(error => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                }
            })
            .finally(() => isLoading.value = false)
    }

    const deleteProyecto = async (id) => {
        swal({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this action!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            confirmButtonColor: '#ef4444',
            timer: 20000,
            timerProgressBar: true,
            reverseButtons: true
        })
            .then(result => {
                if (result.isConfirmed) {
                    axios.delete('/api/proyectos/' + id)
                        .then(response => {
                            getProyectos()
                            router.push({name: 'proyectos.index'})
                            swal({
                                icon: 'success',
                                title: 'Proyecto borrado correctamente'
                            })
                        })
                        .catch(error => {
                            swal({
                                icon: 'error',
                                title: 'Algo ha salido mal'
                            })
                        })
                }
            })

    }

    return {
        proyectos,
        proyecto,
        getProyectos,
        getProyecto,
        storeProyecto,
        updateProyecto,
        deleteProyecto,
        validationErrors,
        isLoading
    }
}
