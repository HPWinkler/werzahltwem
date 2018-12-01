<template>
    <div class="container">

        <div style="background: linear-gradient(to right top, #051937, #004d7a, #008793, #00bf72, #a8eb12); color: white" class="jumbotron">
            <div class="container text-center">
                <h1 class="display-3">Meine Gruppen</h1>
                <p>
                    Übersicht über deine Gruppen. <br>
                    Hier kannst du sie erstellen und modifizieren.
                </p>
                <p>
                    <button @click="initAddGroup()" class="btn btn-success btn-lg">
                        + Neue Gruppe
                    </button>
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Meine Gruppen
                    </div>

                    <div class="panel-body">
                        <table class="table table-bordered table-striped table-responsive" v-if="groups.length > 0">
                            <tbody>
                            <tr>
                                <th>Nr.</th>
                                <th>Gruppenname</th>
                                <th></th>
                                <th>Erstellt am</th>
                            </tr>
                            <tr v-for="(group, index) in groups">
                                <td>{{ index + 1 }}</td>
                                <td><a :href="'/group/' + group.title + '/teilnehmer'">{{ group.title }}</a></td>
                                <td>
                                    <button @click="initShowGroup(index)" class="btn btn-primary btn-xs">Teilnehmerliste</button>
                                    <button @click="initUpdateTeilnehmer(index)" class="btn btn-success btn-xs">Neuer Teilnehmer</button>
                                    <button @click="showPayGroup(index)" class="btn btn-info btn-xs">Ausgabenliste</button>
                                    <button @click="showAbrechnung(index)" class="btn btn-warning btn-xs">Endabrechnung</button>
                                    <button @click="deleteGroup(index)" class="btn btn-danger btn-xs">Gruppe schließen</button>
                                </td>
                                <td>{{ group.created_at }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" tabindex="-1" role="dialog" id="add_group_model">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Neue Gruppe erstellen</h4>
                    </div>
                    <div class="modal-body">

                        <div class="alert alert-danger" v-if="errors.length > 0">
                            <ul>
                                <li v-for="error in errors">{{ error }}</li>
                            </ul>
                        </div>

                        <div class="form-group">
                            <label for="title">Name der Gruppe</label>
                            <input type="text" name="title" id="title" placeholder="Gruppenname" class="form-control"
                                   v-model="group.title">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
                        <button type="button" @click="createGroup" class="btn btn-primary">Gruppe erstellen</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


        <div class="modal fade" tabindex="-1" role="dialog" id="update_teilnehmer_model">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><b>Neuer Teilnehmer</b></h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" v-if="errors.length > 0">
                            <ul>
                                <li v-for="error in errors">{{ error }}</li>
                            </ul>
                        </div>

                        <div class="form-group">
                            <input type="text" placeholder="Name des Teilnehmers" class="form-control"
                                   v-model="update_group.newTeilnehmer">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="updateGroup" class="btn btn-primary">+ Teilnehmer</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


        <div class="modal fade" tabindex="-1" role="dialog" id="show_group_model">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><b>Teilnehmerübersicht</b></h4>
                    </div>

                    <div class="modal-body">
                        <ul>
                            <li v-for="data in show_group.teilnehmerview" v-if="data.mussZahlen >= 0">
                                {{ data.tn_name }} bekommt {{ data.mussZahlen }} €
                            </li>
                            <li v-for="data in show_group.teilnehmerview" v-if="data.mussZahlen < 0">
                                {{ data.tn_name }} muss {{ data.mussZahlen }} € zahlen
                            </li>
                        </ul>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


        <div class="modal fade" tabindex="-1" role="dialog" id="show_ausgaben_model">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><b>Ausgabenübersicht</b></h4>
                    </div>

                    <div class="modal-body">
                        <ul>
                            <li v-for="skill in show_group.ausgabenview">
                                 {{ skill.wer }} zahlt {{ skill.preis }} € für {{ skill.was }}
                            </li>
                        </ul>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


        <div class="modal fade" tabindex="-1" role="dialog" id="show_abrechnung_model">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><b>Endabrechnung</b></h4>
                    </div>

                    <div class="modal-body">
                        <ul>
                            <li v-for="skill in abrechnung_group">
                                {{ skill }}
                            </li>
                        </ul>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Schließen</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>

</template>

<script>
    export default {
        data(){
            return {
                group: {
                    title: '',
                    teilnehmerview: {},
                    ausgabenview: {},
                    wer: '',
                    newTeilnehmer:'',
                    was: '',
                    preis: ''
                },
                errors: [],
                groups: [],
                update_group: {},
                show_group: [],
                abrechnung_group: []
            }
        },
        mounted()
        {
            this.readGroups();
        },
        methods: {
            readGroups()
            {
                axios.get('/group')
                    .then(response => {
                        this.groups = response.data.groups;
                    });
            },
            initShowGroup(index)
            {
                $("#show_group_model").modal("show");
                this.test = this.groups[index];

                axios.get('/group/' + this.test.title)
                    .then(response => {
                        this.show_group = response.data.group;
                    });
            },
            showPayGroup(index)
            {
                $("#show_ausgaben_model").modal("show");
                this.test = this.groups[index];

                axios.get('/group/' + this.test.title)
                    .then(response => {
                        this.show_group = response.data.group;
                    });
            },
            showAbrechnung(index)
            {
                $("#show_abrechnung_model").modal("show");
                this.test = this.groups[index];

                axios.get('/group/' + this.test.title + '/berechnen')
                    .then(response => {
                        this.abrechnung_group = response.data.wzw;
                    });
            },
            initAddGroup()
            {
                $("#add_group_model").modal("show");
            },
            createGroup()
            {
                axios.post('/group', {
                    title: this.group.title,
                })
                    .then(response => {

                        this.reset();

                        this.groups.push(response.data.group);

                        $("#add_group_model").modal("hide");

                    })
                    .catch(error => {
                        this.errors = [];
                        console.log(error);
                        if (error.response.data.errors.title) {
                            this.errors.push(error.response.data.errors.title[0]);
                        }
                    });
            },
            reset()
            {
                this.group.title = '';
            },
            initUpdateTeilnehmer(index)
            {
                this.errors = [];
                $("#update_teilnehmer_model").modal("show");
                this.update_group = this.groups[index];
            },
            updateGroup()
            {
                axios.patch('/group/' + this.update_group.title, {
                    title: this.update_group.title,
                    teilnehmerview: this.update_group.newTeilnehmer
                })
                    .then(response => {
                        this.update_group.newTeilnehmer = '';
                        console.log(response.data);
                    })
                    .catch(error => {
                        this.errors = [];
                        console.log(error);
                        if (error.response.data.errors.name) {
                            this.errors.push(error.response.data.errors.title[0]);
                        }
                    });
            },
            deleteGroup(index)
            {
                let conf = confirm("Möchte sie diese Gruppe wirklich schließen?");
                if (conf === true) {

                    axios.delete('/group/' + this.groups[index].title)
                        .then(response => {

                            this.groups.splice(index, 1);

                        })
                        .catch(error => {

                        });
                }
            }
        }
    }
</script>