<template>
    <div class="grid">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between pb-2 mb-2">
                        <h5 class="card-title">Todas las tareas</h5>
                        <div>
<<<<<<< HEAD
                            <router-link class="btn btn-success" :to="{name:'tasks.create'}">Nueva Tarea</router-link>
=======
                            <RouterLink :to="{name:'tasks.create'}" class="btn btn-success">Nueva tarea</RouterLink>
>>>>>>> 962a4ad8f6ae4bd8a7f551e57bb2078fb8bafcb9
                        </div>
                    </div>


                    <table class="table table-hover table-sm">
                        <thead class="bg-dark text-light">
                            <tr>
                                <th width="50" class="text-center">#</th>
                                <th>Name</th>
                                <th>description</th>
                                <th>date_open</th>
                                <th>date_close</th>
                                <th class="text-center" width="200">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(task, index) in tasks">
                                <td class="text-center">{{ task.id }}</td>
                                <td>{{ task.name }}</td>
                                <td>{{ task.description }}</td>
                                <td>{{ task.date_open }}</td>
                                <th>{{ task.date_close }}</th>
                                <td class="text-center">
                                    <router-link class="btn btn-warning mr-1" :to="{name:'tasks.edit'}">Edit</router-link>
                                    <button @click="deleteTask(task.id, index)" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
</template>


<script setup>
import axios from "axios";
import { ref, inject, onMounted } from "vue";
const tasks = ref();
const swal = inject('$swal');

onMounted(() => {
    axios.get('/api/tasks')
        .then(response => {
            tasks.value = response.data;
<<<<<<< HEAD

        })
=======
            console.log(response.data);
        })
        .catch(error => {
            console.error("Error fetching tasks:", error);
        });
>>>>>>> 962a4ad8f6ae4bd8a7f551e57bb2078fb8bafcb9
});

const deleteTask = (id, index) => {
    swal({
<<<<<<< HEAD
        title: 'Quieres eliminar la tarea?',
        text: 'Esta acción no es reversible!',
=======
        title: '¿Quieres eliminar la tarea?',
        text: 'Esta acción no se puede revertir.',
>>>>>>> 962a4ad8f6ae4bd8a7f551e57bb2078fb8bafcb9
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        confirmButtonColor: '#ef4444',
        timer: 20000,
        timerProgressBar: true,
        reverseButtons: true
<<<<<<< HEAD
    })
        .then(result => {
            if (result.isConfirmed) {
                axios.delete('/api/tasks/' + id)
                    .then(response => {
                        tasks.value.splice(index, 1);
                        swal({
                            icon: 'success',
                            title: 'Tarea eliminada correctamente'
                        });
                    }).catch(error => {
                        swal({
                            icon: 'error',
                            title: 'Error al eliminar la tarea'
                        });
                    })
            }
        })


}
</script>


<style></style>
=======
    }).then(result => {
        if (result.isConfirmed) {
            axios.delete('/api/tasks/' + id)
                .then(response => {
                    tasks.value.splice(index, 1);
                    swal({
                        icon: 'success',
                        title: 'Se ha eliminado la tarea exitosamente.'
                    });
                })
                .catch(error => {
                    swal({
                        icon: 'error',
                        title: 'Error al eliminar la tarea.'
                    });
                    console.error("Error deleting task:", error);
                });
        }
    });
};
</script>


<style></style>
>>>>>>> 962a4ad8f6ae4bd8a7f551e57bb2078fb8bafcb9
