<template>
    <v-app id="inspire">
        <v-content>
            <v-container class="fill-height" fluid>
                <v-row align="center" justify="center">
                    <v-col cols="12" sm="8" md="4">
                        <v-card class="elevation-12">
                            <v-toolbar color="error" dark flat>
                                <v-toolbar-title>Login Form</v-toolbar-title>
                                <v-spacer />
                            </v-toolbar>
                            <v-progress-linear
                                :active="loading"
                                :indeterminate="loading"
                                absolute
                                top
                                color="deep-purple accent-4"
                            ></v-progress-linear>
                            <v-card-text>
                                <v-form ref="form" v-model="valid">
                                    <v-text-field
                                        label="Login"
                                        name="login"
                                        v-model="email"
                                        :rules="emailRules"
                                        prepend-icon="mdi-account-circle-outline"
                                        type="text"
                                        required
                                    />

                                    <v-text-field
                                        id="password"
                                        label="Password"
                                        name="password"
                                        v-model="password"
                                        prepend-icon="mdi-account-lock-outline"
                                        type="password"
                                        required
                                    />
                                </v-form>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer />
                                <v-btn
                                    :disabled="!valid"
                                    color="error"
                                    @click="login"
                                    >Login</v-btn
                                >
                            </v-card-actions>
                        </v-card>
                        <v-snackbar v-model="snackbar">
                            {{ text }}
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
    created() {
        this.$vuetify.theme.dark = true;
    },
    data() {
        return {
            email: "",
            password: "",
            loading: false,
            snackbar: false,
            text: "",
            valid: true,
            emailRules: [
                v => !!v || "E-mail is required",
                v => /.+@.+\..+/.test(v) || "E-mail must be valid"
            ],
            passwordRules: [v => !!v || "Password is required"]
        };
    },
    methods: {
        login: function() {
            // Add a request interceptor
            axios.interceptors.request.use(
                config => {
                    this.loading = true;
                    // Do something before request is sent
                    return config;
                },
                error => {
                    this.loading = false;
                    // Do something with request error
                    return Promise.reject(error);
                }
            );

            // Add a response interceptor
            axios.interceptors.response.use(
                response => {
                    this.loading = false;
                    // Any status code that lie within the range of 2xx cause this function to trigger
                    // Do something with response data
                    return response;
                },
                error => {
                    this.loading = false;
                    // Any status codes that falls outside the range of 2xx cause this function to trigger
                    // Do something with response error
                    return Promise.reject(error);
                }
            );
            axios
                .post("/api/login", {
                    email: this.email,
                    password: this.password
                })
                .then(res => {
                    localStorage.setItem("token", res.data.token);
                    localStorage.setItem("loggedIn", true);
                    this.$router
                        .push("/admin")
                        .then(res => console.log("logged"))
                        .catch(err => console.log(err));
                })
                .catch(err => {
                    console.log(err.response.data.status);
                    this.text = err.response.data.status;
                    this.snackbar = true;
                });
        }
    }
};
</script>
<style scoped></style>
