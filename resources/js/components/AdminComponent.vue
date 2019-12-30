<template>
    <v-app id="inspire">
        <v-navigation-drawer v-model="drawer" app clipped>
            <v-list dense>
                <v-list-item
                    v-for="item in items"
                    :key="item.text"
                    link
                    :to="item.action"
                >
                    <v-list-item-action>
                        <v-icon>mdi-{{ item.icon }}</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>
                            {{ item.text }}
                        </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-subheader class="mt-4 grey--text text--darken-1"
                    >SUBSCRIPTIONS</v-subheader
                >
                <v-list>
                    <v-list-item v-for="item in items2" :key="item.text" link>
                        <v-list-item-avatar>
                            <img
                                :src="
                                    `https://randomuser.me/api/portraits/men/${item.picture}.jpg`
                                "
                                alt=""
                            />
                        </v-list-item-avatar>
                        <v-list-item-title v-text="item.text" />
                    </v-list-item>
                </v-list>
                <v-list-item class="mt-4" link>
                    <v-list-item-action>
                        <v-icon color="grey darken-1"
                            >mdi-plus-circle-outline</v-icon
                        >
                    </v-list-item-action>
                    <v-list-item-title class="grey--text text--darken-1"
                        >Browse Channels</v-list-item-title
                    >
                </v-list-item>
                <v-list-item link @click="logout">
                    <v-list-item-action>
                        <v-icon color="grey darken-1">mdi-settings</v-icon>
                    </v-list-item-action>
                    <v-list-item-title class="grey--text text--darken-1"
                        >Logout</v-list-item-title
                    >
                </v-list-item>
            </v-list>
        </v-navigation-drawer>

        <v-app-bar app clipped-left color="red" dense>
            <!-- <v-btn text to="/admin" left> -->
            <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
            <v-icon class="mx-4">fab fa-youtube</v-icon>
            <v-toolbar-title class="mr-12 align-center">
                <router-link to="/admin">
                    <span class="title">Admin</span>
                </router-link>
            </v-toolbar-title>
            <!-- </v-btn> -->
            <v-spacer />
            <v-row align="center" style="max-width: 650px">
                <v-text-field
                    :append-icon-cb="() => {}"
                    placeholder="Search..."
                    single-line
                    append-icon="search"
                    color="white"
                    hide-details
                />
            </v-row>
        </v-app-bar>

        <v-content>
            <v-container class="">
                <router-view></router-view>
                <v-row justify="center" align="center">
                    <v-col>
                        <v-snackbar v-model="snackbar">
                            Logged in successfully
                            <v-btn color="pink" text @click="snackbar = false">
                                Close
                            </v-btn>
                        </v-snackbar>
                    </v-col>
                </v-row>
            </v-container>
        </v-content>
    </v-app>
</template>
<script>
export default {
    props: {
        source: String
    },
    data: () => ({
        drawer: null,
        snackbar: false,
        items: [
            { icon: "account", text: "Users", action: "/admin/users" },
            { icon: "post-outline", text: "Posts", action: "/admin/posts" },
            {
                icon: "circle-edit-outline",
                text: "Pages",
                action: "/admin/pages"
            },
            {
                icon: "briefcase-edit-outline",
                text: "Categories",
                action: "/admin/categories"
            },
            {
                icon: "account-badge-outline",
                text: "Roles",
                action: "/admin/roles"
            }
        ],
        items2: [
            { picture: 28, text: "Joseph" },
            { picture: 38, text: "Apple" },
            { picture: 48, text: "Xbox Ahoy" },
            { picture: 58, text: "Nokia" },
            { picture: 78, text: "MKBHD" }
        ]
    }),
    created() {
        this.$vuetify.theme.dark = true;
    },
    mounted() {
        this.snackbar = localStorage.getItem("loggedIn");
        localStorage.removeItem("loggedIn");
    },
    methods: {
        logout: function() {
            localStorage.removeItem("token");
            this.$router
                .push("/login")
                .then(res => console.log("logged out"))
                .catch(err => console.log(err));
        }
    }
};
</script>
<style scoped>
.router-link-active {
    text-decoration: none;
    color: #fff;
}
</style>
