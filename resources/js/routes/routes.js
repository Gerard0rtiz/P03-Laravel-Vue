import Cookies from 'js-cookie'
import store from "../store";

const AuthenticatedLayout = () => import('../layouts/Authenticated.vue')
const GuestLayout = () => import('../layouts/Guest.vue');

const PostsIndex = () => import('../views/admin/posts/Index.vue');
const PostsCreate = () => import('../views/admin/posts/Create.vue');
const PostsEdit = () => import('../views/admin/posts/Edit.vue');

const ExercisesIndex = () => import('../views/admin/exercises/Index.vue');
const ExercisesCreate = () => import('../views/admin/exercises/Create.vue');
const ExercisesEdit = () => import('../views/admin/exercises/Edit.vue');

const TaskList = () => import('../views/admin/tasks/index.vue');
const TaskCreate = () => import('../views/admin/tasks/create.vue');
const TaskEdit = () => import('../views/admin/tasks/edit.vue');

//rutas a userProyecto
const UserProyectoVista = () => import('../views/user-proyectos/editUser.vue');

//rutas a tecnologiasUsers
const tecnologiasUsersVista = () => import('../views/tecnologia-user/tecnologiasUsers.vue');

//rutas a skillsUsers
const skillsUsersVista = () => import('../views/skill-user/skillsUsers.vue');

//rutas a proyecto
const ProyectoList = () => import('../views/admin/proyectos/Index.vue');
const ProyectoCreate = () => import('../views/admin/proyectos/Create.vue');
const ProyectoEdit = () => import('../views/admin/proyectos/Edit.vue');
const ProyectoVista = () => import('../views/proyecto/index.vue');
//rutas a imputacion
const ImputacionList = () => import('../views/admin/imputaciones/Index.vue');
const ImputacionCreate = () => import('../views/admin/imputaciones/Create.vue');
const ImputacionEdit = () => import('../views/admin/imputaciones/Edit.vue');
//rutas a fichaje
const FichajeList = () => import('../views/admin/fichajes/Index.vue');
const FichajeCreate = () => import('../views/admin/fichajes/Create.vue');
const FichajeEdit = () => import('../views/admin/fichajes/Edit.vue');
//rutas a imputacion
const SkillList = () => import('../views/admin/skills/Index.vue');
const SkillCreate = () => import('../views/admin/skills/Create.vue');
const SkillEdit = () => import('../views/admin/skills/Edit.vue');
//rutas a imputacion
const TecnologiaList = () => import('../views/admin/tecnologias/Index.vue');
const TecnologiaCreate = () => import('../views/admin/tecnologias/Create.vue');
const TecnologiaEdit = () => import('../views/admin/tecnologias/Edit.vue');

function requireLogin(to, from, next) {
    let isLogin = false;
    isLogin = !!store.state.auth.authenticated;

    if (isLogin) {
        next()
    } else {
        next('/login')
    }
}

function guest(to, from, next) {
    let isLogin;
    isLogin = !!store.state.auth.authenticated;

    if (isLogin) {
        next('/')
    } else {
        next()
    }
}

export default [
    {
        path: '/',
        // redirect: { name: 'login' },
        component: GuestLayout,
        children: [

            {
                name: 'EditarUsuarios',
                path: '/editar-usuarios/:id',
                meta: { breadCrumb: 'Editar usuarios asignados' },
                component: () => import('../views/user-proyectos/editUser.vue'),
                children: [
                    {
                        name: 'UserProyecto.index',
                        path: '',
                        component: () => import('../views/user-proyectos/editUser.vue'),
                    },
                ]
            },
            {
                name: 'EditarSkills',
                path: '/editar-skills/:id',
                meta: { breadCrumb: 'Editar skills de empleados' },
                component: () => import('../views/skill-user/skillsUsers.vue'),
                children: [
                    {
                        name: 'SkillUser.index',
                        path: '',
                        component: () => import('../views/skill-user/skillsUsers.vue'),
                    },
                ]
            },
            {
                name: 'EditarTecnologias',
                path: '/editar-tecnologias/:id',
                meta: { breadCrumb: 'Editar tecnologias de empleados' },
                component: () => import('../views/tecnologia-user/tecnologiasUsers.vue'),
                children: [
                    {
                        name: 'TecnologiaUser.index',
                        path: '',
                        component: () => import('../views/tecnologia-user/tecnologiasUsers.vue'),
                    },
                ]
            },
            {
                path: '/',
                name: 'home',
                component: () => import('../views/home/index.vue'),
            },
            {
                path: 'posts',
                name: 'public-posts.index',
                component: () => import('../views/posts/index.vue'),
            },
            {
                path: 'posts/:id',
                name: 'public-posts.details',
                component: () => import('../views/posts/details.vue'),
            },
            {
                path: 'category/:id',
                name: 'category-posts.index',
                component: () => import('../views/category/posts.vue'),
            },
            {
                path: 'login',
                name: 'auth.login',
                component: () => import('../views/login/Login.vue'),
                beforeEnter: guest,
            },
            {
                path: 'register',
                name: 'auth.register',
                component: () => import('../views/register/index.vue'),
                beforeEnter: guest,
            },
            {
                path: 'forgot-password',
                name: 'auth.forgot-password',
                component: () => import('../views/auth/passwords/Email.vue'),
                beforeEnter: guest,
            },
            {
                path: 'reset-password/:token',
                name: 'auth.reset-password',
                component: () => import('../views/auth/passwords/Reset.vue'),
                beforeEnter: guest,
            },
            {
                name: 'Proyecto',
                path: '/ProyectoVista/:id/:titulo',
                meta: { breadCrumb: 'Proyecto' },
                children: [
                    {
                        name: 'Proyecto.index',
                        path: '',
                        component: ProyectoVista,
                        meta: { breadCrumb: 'Proyecto' }
                    },
                ]
            },
        ]
    },
    {
        path: '/admin',
        component: AuthenticatedLayout,
        // redirect: {
        //     name: 'admin.index'
        // },
        beforeEnter: requireLogin,
        meta: { breadCrumb: 'Dashboard' },
        children: [
            {
                name: 'admin.index',
                path: '',
                component: () => import('../views/admin/index.vue'),
                meta: { breadCrumb: 'Admin' }
            },
            {
                name: 'profile.index',
                path: 'profile',
                component: () => import('../views/admin/profile/index.vue'),
                meta: { breadCrumb: 'Profile' }
            },
            {
                name: 'posts.index',
                path: 'posts',
                component: PostsIndex,
                meta: { breadCrumb: 'Posts' }
            },
            {
                name: 'posts.create',
                path: 'posts/create',
                component: PostsCreate,
                meta: { breadCrumb: 'Add new post' }
            },
            {
                name: 'posts.edit',
                path: 'posts/edit/:id',
                component: PostsEdit,
                meta: { breadCrumb: 'Edit post' }
            },

            {
                name: 'tasks',
                path: 'tasks',
                meta: { breadCrumb: 'Tareas' },
                children: [
                    {
                        name: 'tasks.index',
                        path: '',
                        component: TaskList,
                        meta: { breadCrumb: 'Listado tareas' }
                    },
                    {
                        name: 'tasks.create',
                        path: 'create',
                        component: TaskCreate,
                        meta: { breadCrumb: 'Crear tarea' }
                    },
                    {
                        name: 'tasks.edit',
                        path: 'edit',
                        component: TaskEdit,
                        meta: { breadCrumb: 'Editar tarea' }
                    }
                ]
            },

            {
                name: 'skills',
                path: 'skills',
                meta: { breadCrumb: 'Skills' },
                children: [
                    {
                        name: 'skills.index',
                        path: '',
                        component: SkillList,
                        meta: { breadCrumb: 'Listado skills' }
                    },
                    {
                        name: 'skills.create',
                        path: 'create',
                        component: SkillCreate,
                        meta: { breadCrumb: 'Crear skill' }
                    },
                    {
                        name: 'skills.edit',
                        path: 'edit/:id',
                        component: SkillEdit,
                        meta: { breadCrumb: 'Editar skill' }
                    }
                ]
            },

            {
                name: 'tecnologias',
                path: 'tecnologias',
                meta: { breadCrumb: 'Tecnologias' },
                children: [
                    {
                        name: 'tecnologias.index',
                        path: '',
                        component: TecnologiaList,
                        meta: { breadCrumb: 'Listado tecnologias' }
                    },
                    {
                        name: 'tecnologias.create',
                        path: 'create',
                        component: TecnologiaCreate,
                        meta: { breadCrumb: 'Crear tecnologia' }
                    },
                    {
                        name: 'tecnologias.edit',
                        path: 'edit/:id',
                        component: TecnologiaEdit,
                        meta: { breadCrumb: 'Editar tecnologia' }
                    }
                ]
            },

            {
                name: 'proyectos',
                path: 'proyectos',
                meta: { breadCrumb: 'Proyectos' },
                children: [
                    {
                        name: 'proyectos.index',
                        path: '',
                        component: ProyectoList,
                        meta: { breadCrumb: 'Listado proyectos' }
                    },
                    {
                        name: 'proyectos.create',
                        path: 'create',
                        component: ProyectoCreate,
                        meta: { breadCrumb: 'Crear proyecto' }
                    },
                    {
                        name: 'proyectos.edit',
                        path: 'edit/:id',
                        component: ProyectoEdit,
                        meta: { breadCrumb: 'Editar proyecto' }
                    }
                ]
            },

            {
                name: 'fichajes',
                path: 'fichajes',
                meta: { breadCrumb: 'Fichajes' },
                children: [
                    {
                        name: 'fichajes.index',
                        path: '',
                        component: FichajeList,
                        meta: { breadCrumb: 'Listado fichajes' }
                    },
                    {
                        name: 'fichajes.create',
                        path: 'create',
                        component: FichajeCreate,
                        meta: { breadCrumb: 'Crear fichaje' }
                    },
                    {
                        name: 'fichajes.edit',
                        path: 'edit/:id',
                        component: FichajeEdit,
                        meta: { breadCrumb: 'Editar fichaje' }
                    }
                ]
            },
            {
                name: 'imputaciones',
                path: 'imputaciones',
                meta: { breadCrumb: 'Imputaciones' },
                children: [
                    {
                        name: 'imputaciones.index',
                        path: '',
                        component: ImputacionList,
                        meta: { breadCrumb: 'Listado imputaciones' }
                    },
                    {
                        name: 'imputaciones.create',
                        path: 'create',
                        component: ImputacionCreate,
                        meta: { breadCrumb: 'Crear imputacion' }
                    },
                    {
                        name: 'imputaciones.edit',
                        path: 'edit/:id',
                        component: ImputacionEdit,
                        meta: { breadCrumb: 'Editar imputacion' }
                    }
                ]
            },

            {
                name: 'exercises',
                path: 'exercises',
                meta: { breadCrumb: 'Exercises' },
                children: [
                    {
                        name: 'exercises.index',
                        path: '',
                        component: ExercisesIndex,
                        meta: { breadCrumb: 'View' }
                    },
                    {
                        name: 'exercises.create',
                        path: 'create',
                        component: ExercisesCreate,
                        meta: {
                            breadCrumb: 'Add new exercise',
                            linked: false,
                        }
                    },
                    {
                        name: 'exercises.edit',
                        path: 'edit/:id',
                        component: ExercisesEdit,
                        meta: {
                            breadCrumb: 'Edit exercise',
                            linked: false,
                        }
                    }
                ]
            },

            {
                name: 'categories',
                path: 'categories',
                meta: { breadCrumb: 'Categories' },
                children: [
                    {
                        name: 'categories.index',
                        path: '',
                        component: () => import('../views/admin/categories/Index.vue'),
                        meta: { breadCrumb: 'View category' }
                    },
                    {
                        name: 'categories.create',
                        path: 'create',
                        component: () => import('../views/admin/categories/Create.vue'),
                        meta: {
                            breadCrumb: 'Add new category',
                            linked: false,
                        }
                    },
                    {
                        name: 'categories.edit',
                        path: 'edit/:id',
                        component: () => import('../views/admin/categories/Edit.vue'),
                        meta: {
                            breadCrumb: 'Edit category',
                            linked: false,
                        }
                    }
                ]
            },

            {
                name: 'permissions',
                path: 'permissions',
                meta: { breadCrumb: 'Permisos' },
                children: [
                    {
                        name: 'permissions.index',
                        path: '',
                        component: () => import('../views/admin/permissions/Index.vue'),
                        meta: { breadCrumb: 'Permissions' }
                    },
                    {
                        name: 'permissions.create',
                        path: 'create',
                        component: () => import('../views/admin/permissions/Create.vue'),
                        meta: {
                            breadCrumb: 'Create Permission',
                            linked: false,
                        }
                    },
                    {
                        name: 'permissions.edit',
                        path: 'edit/:id',
                        component: () => import('../views/admin/permissions/Edit.vue'),
                        meta: {
                            breadCrumb: 'Permission Edit',
                            linked: false,
                        }
                    }
                ]
            },

            //TODO Organizar rutas
            {
                name: 'roles.index',
                path: 'roles',
                component: () => import('../views/admin/roles/Index.vue'),
                meta: { breadCrumb: 'Roles' }
            },
            {
                name: 'roles.create',
                path: 'roles/create',
                component: () => import('../views/admin/roles/Create.vue'),
                meta: { breadCrumb: 'Create Role' }
            },
            {
                name: 'roles.edit',
                path: 'roles/edit/:id',
                component: () => import('../views/admin/roles/Edit.vue'),
                meta: { breadCrumb: 'Role Edit' }
            },
            {
                name: 'users.index',
                path: 'users',
                component: () => import('../views/admin/users/Index.vue'),
                meta: { breadCrumb: 'Users' }
            },
            {
                name: 'users.create',
                path: 'users/create',
                component: () => import('../views/admin/users/Create.vue'),
                meta: { breadCrumb: 'Add New' }
            },
            {
                name: 'users.edit',
                path: 'users/edit/:id',
                component: () => import('../views/admin/users/Edit.vue'),
                meta: { breadCrumb: 'User Edit' }
            },
        ]
    },
    {
        path: "/:pathMatch(.*)*",
        name: 'NotFound',
        component: () => import("../views/errors/404.vue"),
    },
];
