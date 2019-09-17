export default class Auth {

  constructor(user) {
    this.user=user;
  }

  roles(){
    return this.user.roles.map(role=>role.name);
  }

  permissions(){
    return this.user.permissions.map(permission=>permission.name);
  }

  isTeam(){
    return this.user.user.account_role == 0;
  }

  isClient(){
    return this.user.user.account_role == 2;
  }

  isAdmin(){
    return this.user.user.account_role == 1;
  }

  auth(){
    return this.user.user;
  }

  can($permissionName){
    return this.permissions().includes($permissionName);
  }


}