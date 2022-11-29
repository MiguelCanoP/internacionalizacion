import {checkIfModelHasEmptyProperties, toObjectRequest} from "@/HelperFunctions";

export default class University {
    toObjectRequest() {
        return toObjectRequest(this, true);
    }

    hasEmptyProperties() {
        return checkIfModelHasEmptyProperties(this);
    }

    static fromModel(model) {
        return new University(model.id, model.name, model.website, model.country);
    }

    constructor(id = null, name = '', website = '', country = null) {
        this.id = id;
        this.name = name;
        this.website = website;
        this.country = country;

        this.dataStructure = {
            id: null,
            name: 'required',
            website: 'required',
            country: 'required',
        }
    }
}
