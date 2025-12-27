import api from './http';

export const ensureAuth = async () => {
  await api.post('/auth/login');
};
