import {checkIfModelHasEmptyProperties, toObjectRequest} from "@/HelperFunctions";

export default class Agreement {
    toObjectRequest() {
        return toObjectRequest(this, true);
    }

    hasEmptyProperties() {
        return checkIfModelHasEmptyProperties(this);
    }

    static createAgreementsFromArray(models) {
        let agreements = []
        models.forEach(function (model) {
            //Remove pivot from programs
            model.programs.forEach(function (program) {
                delete program.pivot;
            })
            agreements.push(new Agreement(model.id, model.agreement_type, model.status, model.information, model.contact_info, model.university, model.programs));
        })
        return agreements;
    }

    static getPossibleStatuses() {
        return [
            {
                value: 'vigente',
                placeholder: 'Vigente'
            },
            {
                value: 'en renovación',
                placeholder: 'En renovación'
            },
            {
                value: 'vencido',
                placeholder: 'Vencido'
            },
        ]
    }

    static fromModel(model) {
        console.log('modelo', model);
        console.log('creado', new Agreement(model.id, model.agreementType, model.status, model.information, model.contactInfo, model.university, model.programs))
        return new Agreement(model.id, model.agreementType, model.status, model.information, model.contactInfo, model.university, model.programs);
    }

    constructor(id = null, agreementType = null, status = '', information = null, contactInfo = '', university = null, programs = []) {
        this.id = id;
        this.agreementType = agreementType;
        this.status = status;
        this.information = information;
        this.contactInfo = contactInfo;
        this.university = university;
        this.programs = programs;

        this.dataStructure = {
            id: null,
            agreementType: 'required',
            status: 'required',
            information: 'required',
            contactInfo: 'required',
            university: 'required',
            programs: 'required',
        }
    }

}
