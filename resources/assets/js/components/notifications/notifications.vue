<template>
  <li class="dropdown" onclick="markNotifcationsRead()">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
      <span class="glyphicon glyphicon-globe"></span> Notifications <span class="badge">{{ unreadCount + newNotifications.length }}</span>
    </a>

    <ul class="dropdown-menu" role="menu" style="padding: 0;">
      <li v-for="notification in newNotifications" class="unread">
        <a :href="'http://one.app/posts/' + notification.post_slug">
          <span v-show="notification.type == 'App\\Notifications\\newCategoryPost'">
            <b>{{ notification.post_user }}</b>
            created a new <b><i>{{ notification.category_name }}</i></b> Post
          </span>

          <span v-show="notification.type == 'App\\Notifications\\newComment'">
            <b>{{ notification.commenter }}</b>
            commented on your <b><i>{{ notification.post_title }}</i></b> Post
          </span>
        </a>
      </li>

      <li v-for="notification in notifications" :class="(notification.read_at ? 'read': 'unread')">
          <a :href="'http://one.app/posts/' + notification.data.post_slug">
            <span v-show="notification.type == 'App\\Notifications\\newCategoryPost'">
              <b>{{ notification.data.post_user }}</b>
              created a new <b><i>{{ notification.data.category_name }}</i></b> Post
            </span>

            <span v-show="notification.type == 'App\\Notifications\\newComment'">
              <b>{{ notification.data.commenter }}</b>
              commented on your <b><i>{{ notification.data.post_title }}</i></b> Post
            </span>
          </a>
        </li>
    </ul>

  </li>
</template>

<script>
export default {
  props: ['notifications', 'unreadCount', 'userid'],

  data() {
    return {
      newNotifications: [],
    }
  },

  mounted() {
    console.log('Component mounted: ');

    Echo.private('App.User.' + this.userid)
    .notification(
      (notification) => {
        console.log('NEW Notification');
        console.log(notification);
        console.log('NEW Notification');
        this.newNotifications.unshift(notification);
      }
    );
  },
}
</script>

<style scoped>
.unread {
  background-color: #E9EBEE;
}

.read, .unread {
  border-bottom: 1px solid #A5A9B1;
  padding: 5px;
}
a {
  text-decoration: none;
  color: grey;
}
</style>
