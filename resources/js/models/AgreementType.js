import {checkIfModelHasEmptyProperties, toObjectRequest} from "@/HelperFunctions";

export default class AgreementType {
    toObjectRequest() {
        return toObjectRequest(this, true);
    }

    hasEmptyProperties() {
        return checkIfModelHasEmptyProperties(this);
    }

    static fromModel(model) {
        return new AgreementType(model.id, model.name);
    }

    constructor(id = null, name = '') {
        this.id = id;
        this.name = name;

        this.dataStructure = {
            id: null,
            name: 'required',
        }
    }
}
