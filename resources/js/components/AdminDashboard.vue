<template>
  <div>
    <h1>BRT Analytics Dashboard</h1>

    <div class="analytics-section">
      <h2>Total Statistics</h2>
      <ul>
        <li>Total BRTs: {{ totalAnalytics.totalBrts }}</li>
        <li>Active BRTs: {{ totalAnalytics.activeBrts }}</li>
        <li>Expired BRTs: {{ totalAnalytics.expiredBrts }}</li>
        <li>Total Reserved Amount: {{ totalAnalytics.totalReservedAmount }} Blume Coins</li>
      </ul>
    </div>

    <div class="analytics-section">
      <h2>BRTs Created Trends</h2>
      <div>
        <h3>Daily</h3>
        <ul>
          <li v-for="day in trendsAnalytics.brtsPerDay" :key="day.date">
            {{ day.date }}: {{ day.count }}
          </li>
        </ul>
      </div>
      <div>
        <h3>Weekly</h3>
        <ul>
          <li v-for="week in trendsAnalytics.brtsPerWeek" :key="week.week">
            Week {{ week.week }}: {{ week.count }}
          </li>
        </ul>
      </div>
      <div>
        <h3>Monthly</h3>
        <ul>
          <li v-for="month in trendsAnalytics.brtsPerMonth" :key="month.month">
            Month {{ month.month }}: {{ month.count }}
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';  // Import Axios here
import * as Ably from 'ably';  // Import Ably

export default {
  data() {
    return {
      totalAnalytics: {
        totalBrts: 0,
        activeBrts: 0,
        expiredBrts: 0,
        totalReservedAmount: 0,
      },
      trendsAnalytics: {
        brtsPerDay: [],
        brtsPerWeek: [],
        brtsPerMonth: [],
      },
    };
  },
  mounted() {
    this.fetchAnalytics();
    this.setupRealTimeUpdates();
  },
  methods: {
    fetchAnalytics() {
      // Fetch Total Analytics
      axios.get('/admin/analytics/total').then((response) => {
        this.totalAnalytics = response.data;
      });

      // Fetch Trend Analytics
      axios.get('/admin/analytics/trends').then((response) => {
        this.trendsAnalytics = response.data;
      });
    },
    setupRealTimeUpdates() {
      Echo.channel('notification')
      .listen('.analytics', (e) => {
        console.log('BRTUpdated event received:', e);
        this.fetchAnalytics();
      })
      .error((error) => {
        console.error('Error subscribing to the Echo channel:', error);
      });

      // Check connection state
      Echo.connector.pusher.connection.bind('connected', () => {
        console.log('Connected to Pusher!');
      });

      Echo.connector.pusher.connection.bind('error', (error) => {
        console.error('Error with Pusher connection:', error);
      });
    }
  }
};
</script>

<style scoped>
/* Add your styles for the dashboard */
.analytics-section {
  margin-bottom: 20px;
}
</style>
