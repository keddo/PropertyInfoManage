export default class Gate{

    constructor(user){
      this.user = user;
    }

    isSuperAdmin(){
        return this.user.type === 'Super Admin';
    }
    isHead(){
        return this.user.type === 'Head';
    }
    isTeacher(){
        return this.user.type === 'Teacher';
    }
    isSuperAdminOrPropertyAdmin(){
        if((this.user.type == 'Super Admin') || (this.user.type == 'Property Admin')){
            return true;
        }
    }
}